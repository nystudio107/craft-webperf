<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf;

use Craft;
use craft\base\Element;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\DefineHtmlEvent;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\helpers\UrlHelper;
use craft\services\Plugins;
use craft\services\UserPermissions;
use craft\web\Application;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\web\View;
use DateTime;
use Exception;
use nystudio107\pluginvite\services\VitePluginService;
use nystudio107\webperf\assetbundles\webperf\WebperfAsset;
use nystudio107\webperf\base\CraftDataSample;
use nystudio107\webperf\helpers\PluginTemplate;
use nystudio107\webperf\log\ErrorsTarget;
use nystudio107\webperf\log\ProfileTarget;
use nystudio107\webperf\models\RecommendationDataSample;
use nystudio107\webperf\models\Settings;
use nystudio107\webperf\services\Beacons as BeaconsService;
use nystudio107\webperf\services\DataSamples as DataSamplesService;
use nystudio107\webperf\services\ErrorSamples as ErrorSamplesService;
use nystudio107\webperf\services\Recommendations as RecommendationsService;
use nystudio107\webperf\variables\WebperfVariable;
use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * Class Webperf
 *
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 *
 * @property BeaconsService $beacons
 * @property DataSamplesService $dataSamples
 * @property ErrorSamplesService $errorSamples
 * @property RecommendationsService $recommendations
 * @property ErrorsTarget $errorsTarget
 * @property ProfileTarget $profileTarget
 * @property VitePluginService $vite
 */
class Webperf extends Plugin
{
    // Constants
    // =========================================================================

    public const RECOMMENDATIONS_CACHE_KEY = 'webperf-recommendations';
    public const RECOMMENDATIONS_CACHE_DURATION = 60;

    public const ERRORS_CACHE_KEY = 'webperf-errors';
    public const ERRORS_CACHE_DURATION = 60;

    // Static Properties
    // =========================================================================

    /**
     * @var null|Webperf
     */
    public static ?Webperf $plugin = null;

    /**
     * @var null|Settings
     */
    public static ?Settings $settings = null;

    /**
     * @var int|null
     */
    public static ?int $requestUuid = null;

    /**
     * @var int|null
     */
    public static ?int $requestUrl = null;

    /**
     * @var bool
     */
    public static bool $beaconIncluded = false;

    /**
     * @var string
     */
    public static string $renderType = 'html';

    // Static Methods
    // =========================================================================
    /**
     * @var string
     */
    public string $schemaVersion = '1.0.1';

    // Public Properties
    // =========================================================================
    /**
     * @var bool
     */
    public bool $hasCpSection = true;
    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'beacons' => BeaconsService::class,
            'dataSamples' => DataSamplesService::class,
            'errorSamples' => ErrorSamplesService::class,
            'recommendations' => RecommendationsService::class,
            // Register the vite service
            'vite' => [
                'class' => VitePluginService::class,
                'assetClass' => WebperfAsset::class,
                'useDevServer' => true,
                'devServerPublic' => 'http://localhost:3001',
                'serverPublic' => 'http://localhost:8000',
                'errorEntry' => 'src/js/webperf.js',
                'devServerInternal' => 'http://craft-webperf-buildchain:3001',
                'checkDevServer' => true,
            ],
        ];

        parent::__construct($id, $parent, $config);
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        // Initialize properties
        self::$plugin = $this;
        self::$settings = $this->getSettings();
        try {
            self::$requestUuid = random_int(0, PHP_INT_MAX);
        } catch (Exception $e) {
            self::$requestUuid = null;
        }
        $this->name = self::$settings->pluginName;
        // Handle any console commands
        $request = Craft::$app->getRequest();
        if ($request->getIsConsoleRequest()) {
            $this->controllerNamespace = 'nystudio107\webperf\console\controllers';
        }
        // Add in our components
        $this->addComponents();
        // Install event listeners
        $this->installEventListeners();
        // Load that we've loaded
        Craft::info(
            Craft::t(
                'webperf',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * @inheritdoc
     */
    public function getSettingsResponse()
    {
        // Just redirect to the plugin settings page
        Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('webperf/settings'));
    }

    /**
     * @inheritdoc
     */
    public function getCpNavItem(): array
    {
        $subNavs = [];
        $navItem = parent::getCpNavItem();
        $recommendations = $this->getRecommendationsCount();
        $errors = $this->getErrorsCount();
        if (!empty($errors)) {
            $navItem['label'] .= ' ' . $errors;
        }
        $navItem['badgeCount'] = $recommendations;
        $currentUser = Craft::$app->getUser()->getIdentity();
        if ($currentUser) {
            // Only show sub-navs the user has permission to view
            if ($currentUser->can('webperf:dashboard')) {
                $subNavs['dashboard'] = [
                    'label' => Craft::t('webperf', 'Dashboard'),
                    'url' => 'webperf/dashboard',
                ];
            }
            if ($currentUser->can('webperf:performance')) {
                $subNavs['performance'] = [
                    'label' => Craft::t('webperf', 'Performance'),
                    'url' => 'webperf/performance',
                ];
            }
            if ($currentUser->can('webperf:errors')) {
                $subNavs['errors'] = [
                    'label' => Craft::t('webperf', 'Errors') . ' ' . $errors,
                    'url' => 'webperf/errors',
                    'badge' => $errors,
                ];
            }
            /* @TODO Alerts implementation
             * if ($currentUser->can('webperf:alerts')) {
             * $subNavs['alerts'] = [
             * 'label' => 'Alerts',
             * 'url' => 'webperf/alerts',
             * ];
             * }
             */
            $editableSettings = true;
            $general = Craft::$app->getConfig()->getGeneral();
            if (!$general->allowAdminChanges) {
                $editableSettings = false;
            }
            if ($editableSettings && $currentUser->can('webperf:settings')) {
                $subNavs['settings'] = [
                    'label' => Craft::t('webperf', 'Settings'),
                    'url' => 'webperf/settings',
                ];
            }
        }
        return array_merge($navItem, [
            'subnav' => $subNavs,
        ]);
    }

    /**
     * Clear all the caches!
     */
    public function clearAllCaches(): void
    {
    }

    // Protected Methods
    // =========================================================================

    /**
     * Add in our components
     */
    protected function addComponents(): void
    {
        $request = Craft::$app->getRequest();
        if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest() && !$request->getIsLivePreview()) {
            $this->setRequestUrl();
            try {
                $uri = $request->getPathInfo();
            } catch (InvalidConfigException $e) {
                $uri = '';
            }
            // Ignore our own controllers
            if (self::$settings->includeCraftProfiling && !$this->excludeUri($uri)) {
                // Add in the ProfileTarget component
                try {
                    $this->set('profileTarget', [
                        'class' => ProfileTarget::class,
                        'levels' => ['profile'],
                        'categories' => [],
                        'logVars' => [],
                        'except' => [],
                    ]);
                } catch (InvalidConfigException $e) {
                    Craft::error($e->getMessage(), __METHOD__);
                }
                // Attach our log target
                Craft::$app->getLog()->targets['webperf-profile'] = $this->profileTarget;
                // Add in the ErrorsTarget component
                $except = [];
                // If devMode is on, exclude errors/warnings from `seomatic`
                if (Craft::$app->getConfig()->getGeneral()->devMode) {
                    $except = ['nystudio107\seomatic\*'];
                }
                $levels = ['error'];
                if (self::$settings->includeCraftWarnings) {
                    $levels[] = 'warning';
                }
                try {
                    $this->set('errorsTarget', [
                        'class' => ErrorsTarget::class,
                        'levels' => $levels,
                        'categories' => [],
                        'logVars' => [],
                        'except' => $except,
                    ]);
                } catch (InvalidConfigException $e) {
                    Craft::error($e->getMessage(), __METHOD__);
                }
                // Attach our log target
                Craft::$app->getLog()->targets['webperf-errors'] = $this->errorsTarget;
            }
        }
    }

    /**
     * Set the request URL
     *
     * @param bool $force
     */
    protected function setRequestUrl(bool $force = false): void
    {
        self::$requestUrl = CraftDataSample::PLACEHOLDER_URL;
        if (!self::$settings->includeBeacon || $force || self::$settings->staticCachedSite) {
            $request = Craft::$app->getRequest();
            self::$requestUrl = UrlHelper::stripQueryString(
                urldecode($request->getAbsoluteUrl())
            );
        }
    }

    /**
     * Install our event listeners.
     */
    protected function installEventListeners(): void
    {
        $request = Craft::$app->getRequest();
        // Add in our event listeners that are needed for every request
        $this->installGlobalEventListeners();
        // Install only for non-console site requests
        if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest()) {
            $this->installSiteEventListeners();
        }
        // Install only for non-console Control Panel requests
        if ($request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
            $this->installCpEventListeners();
        }
        // Handler: EVENT_AFTER_INSTALL_PLUGIN
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // Invalidate our caches after we've been installed
                    $this->clearAllCaches();
                    // Send them to our welcome screen
                    $request = Craft::$app->getRequest();
                    if ($request->isCpRequest) {
                        Craft::$app->getResponse()->redirect(UrlHelper::cpUrl(
                            'webperf/dashboard',
                            [
                                'showWelcome' => true,
                            ]
                        ))->send();
                    }
                }
            }
        );
    }

    /**
     * Install global event listeners for all request types
     */
    protected function installGlobalEventListeners(): void
    {
        // Handler: CraftVariable::EVENT_INIT
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('webperf', [
                    'class' => WebperfVariable::class,
                    'viteService' => $this->vite,
                ]);
            }
        );
        // Handler: Plugins::EVENT_AFTER_LOAD_PLUGINS
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_LOAD_PLUGINS,
            function () {
                // Install these only after all other plugins have loaded
                $request = Craft::$app->getRequest();
                // Only respond to non-console site requests
                if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest() && !$request->getIsLivePreview()) {
                    $this->handleSiteRequest();
                }
                // Respond to Control Panel requests
                if ($request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
                    $this->handleAdminCpRequest();
                }
            }
        );
    }

    /**
     * Install site event listeners for site requests only
     */
    protected function installSiteEventListeners(): void
    {
        // Handler: UrlManager::EVENT_REGISTER_SITE_URL_RULES
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                Craft::debug(
                    'UrlManager::EVENT_REGISTER_SITE_URL_RULES',
                    __METHOD__
                );
                // Register our Control Panel routes
                $event->rules = array_merge(
                    $event->rules,
                    $this->customFrontendRoutes()
                );
            }
        );
    }

    /**
     * Install site event listeners for Control Panel requests only
     */
    protected function installCpEventListeners(): void
    {
        // Handler: UrlManager::EVENT_REGISTER_CP_URL_RULES
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                Craft::debug(
                    'UrlManager::EVENT_REGISTER_CP_URL_RULES',
                    __METHOD__
                );
                // Register our Control Panel routes
                $event->rules = array_merge(
                    $event->rules,
                    $this->customAdminCpRoutes()
                );
            }
        );
        // Handler: UserPermissions::EVENT_REGISTER_PERMISSIONS
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function (RegisterUserPermissionsEvent $event) {
                Craft::debug(
                    'UserPermissions::EVENT_REGISTER_PERMISSIONS',
                    __METHOD__
                );
                // Register our custom permissions
                $event->permissions[Craft::t('webperf', 'Webperf')] = $this->customAdminCpPermissions();
            }
        );
    }

    /**
     * Handle site requests.  We do it only after we receive the event
     * EVENT_AFTER_LOAD_PLUGINS so that any pending db migrations can be run
     * before our event listeners kick in
     */
    protected function handleSiteRequest(): void
    {
        $request = Craft::$app->getRequest();
        try {
            $uri = $request->getPathInfo();
        } catch (InvalidConfigException $e) {
            $uri = '';
        }
        // Check for URIs to exclude
        if (!$this->excludeUri($uri)) {
            // Handler: View::EVENT_END_PAGE
            Event::on(
                View::class,
                View::EVENT_END_PAGE,
                static function () {
                    Craft::debug(
                        'View::EVENT_END_PAGE',
                        __METHOD__
                    );
                    // Don't include the beacon for response codes >= 400
                    $response = Craft::$app->getResponse();
                    if ($response->statusCode < 400) {
                        $view = Craft::$app->getView();
                        // The page is done rendering, include our beacon
                        if (Webperf::$settings->includeBeacon && $view->getIsRenderingPageTemplate()) {
                            switch (self::$renderType) {
                                case 'html':
                                    Webperf::$plugin->beacons->includeHtmlBeacon();
                                    self::$beaconIncluded = true;
                                    break;
                                case 'amp-html':
                                    Webperf::$plugin->beacons->includeAmpHtmlScript();
                                    break;
                            }
                        }
                    }
                }
            );
            // Handler: View::EVENT_END_BODY
            Event::on(
                View::class,
                View::EVENT_END_BODY,
                static function () {
                    Craft::debug(
                        'View::EVENT_END_BODY',
                        __METHOD__
                    );
                    $view = Craft::$app->getView();
                    // The page is done rendering, include our beacon
                    if (Webperf::$settings->includeBeacon && $view->getIsRenderingPageTemplate()) {
                        switch (self::$renderType) {
                            case 'html':
                                break;
                            case 'amp-html':
                                Webperf::$plugin->beacons->includeAmpHtmlBeacon();
                                self::$beaconIncluded = true;
                                break;
                        }
                    }
                }
            );
            // Handler: Application::EVENT_AFTER_REQUEST
            Event::on(
                Application::class,
                Application::EVENT_AFTER_REQUEST,
                function () {
                    Craft::debug(
                        'Application::EVENT_AFTER_REQUEST',
                        __METHOD__
                    );
                    // If the beacon wasn't included, allow for the Craft timings
                    if (!self::$beaconIncluded) {
                        $this->setRequestUrl(true);
                    }
                }
            );
        }
    }

    /**
     * Handle Control Panel requests. We do it only after we receive the event
     * EVENT_AFTER_LOAD_PLUGINS so that any pending db migrations can be run
     * before our event listeners kick in
     */
    protected function handleAdminCpRequest(): void
    {
        // Handler: Element::EVENT_DEFINE_SIDEBAR_HTML
        Event::on(
            Element::class,
            Element::EVENT_DEFINE_SIDEBAR_HTML,
            function (DefineHtmlEvent $event) {
                Craft::debug(
                    'Element::EVENT_DEFINE_SIDEBAR_HTML',
                    __METHOD__
                );
                // Only show sub-navs the user has permission to view
                $user = Craft::$app->getUser();
                if (self::$settings->displaySidebar && $user->checkPermission('webperf:sidebar')) {
                    /* @var Element $element */
                    $element = $event->sender;
                    $html = '';
                    if ($element->uri !== null) {
                        $html = $this->renderSidebar($element);
                    }
                    $event->html .= $html;
                }
            }
        );
    }

    /**
     * @param Element $element
     *
     * @return string
     */
    protected function renderSidebar(Element $element): string
    {
        $html = '';
        if ($element->url !== null) {
            $view = Craft::$app->getView();
            try {
                $view->registerAssetBundle(WebperfAsset::class);
            } catch (InvalidConfigException $e) {
            }
            try {
                $now = new DateTime();
            } catch (Exception $e) {
                return $html;
            }
            $end = $now->format('Y-m-d');
            $start = $now->modify('-30 days')->format('Y-m-d');
            $html .= PluginTemplate::renderPluginTemplate(
                '_sidebars/webperf-sidebar.twig',
                [
                    'settings' => self::$settings,
                    'pageUrl' => $element->url,
                    'start' => $start,
                    'end' => $end,
                    'currentSiteId' => $element->siteId ?? 0,
                ]
            );
        }

        return $html;
    }

    /**
     * @param $uri
     *
     * @return bool
     */
    protected function excludeUri($uri): bool
    {
        $uri = '/' . ltrim($uri, '/');
        if (!empty(self::$settings->excludePatterns)) {
            foreach (self::$settings->excludePatterns as $excludePattern) {
                $pattern = '`' . $excludePattern['pattern'] . '`i';
                if (preg_match($pattern, $uri) === 1) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'webperf/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }

    /**
     * Return the custom frontend routes
     *
     * @return array
     */
    protected function customFrontendRoutes(): array
    {
        return [
            // Beacon
            '/webperf/metrics/beacon' => 'webperf/metrics/beacon',
            // Render
            '/webperf/render/amp-iframe' => 'webperf/render/amp-iframe',
        ];
    }

    /**
     * Return the custom Control Panel routes
     *
     * @return array
     */
    protected function customAdminCpRoutes(): array
    {
        return [
            'webperf' => 'webperf/sections/dashboard',
            'webperf/dashboard' => 'webperf/sections/dashboard',
            'webperf/dashboard/<siteHandle:{handle}>' => 'webperf/sections/dashboard',

            'webperf/performance' => 'webperf/sections/pages-index',
            'webperf/performance/<siteHandle:{handle}>' => 'webperf/sections/pages-index',

            'webperf/performance/page-detail' => 'webperf/sections/page-detail',
            'webperf/performance/page-detail/<siteHandle:{handle}>' => 'webperf/sections/page-detail',

            'webperf/errors' => 'webperf/sections/errors-index',
            'webperf/errors/<siteHandle:{handle}>' => 'webperf/sections/errors-index',

            'webperf/errors/page-detail' => 'webperf/sections/errors-detail',
            'webperf/errors/page-detail/<siteHandle:{handle}>' => 'webperf/errors/page-detail',

            'webperf/alerts' => 'webperf/sections/alerts',
            'webperf/alerts/<siteHandle:{handle}>' => 'webperf/sections/alerts',

            'webperf/settings' => 'webperf/settings/plugin-settings',
        ];
    }

    /**
     * Returns the custom Control Panel user permissions.
     *
     * @return array
     */
    protected function customAdminCpPermissions(): array
    {
        return [
            'webperf:dashboard' => [
                'label' => Craft::t('webperf', 'Dashboard'),
            ],
            'webperf:performance' => [
                'label' => Craft::t('webperf', 'Performance'),
                'nested' => [
                    'webperf:performance-detail' => [
                        'label' => Craft::t('webperf', 'Performance Detail'),
                    ],
                    'webperf:delete-data-samples' => [
                        'label' => Craft::t('webperf', 'Delete Data Samples'),
                    ],
                ],
            ],
            'webperf:errors' => [
                'label' => Craft::t('webperf', 'Errors'),
                'nested' => [
                    'webperf:errors-detail' => [
                        'label' => Craft::t('webperf', 'Errors Detail'),
                    ],
                    'webperf:delete-error-samples' => [
                        'label' => Craft::t('webperf', 'Delete Error Samples'),
                    ],
                ],
            ],
            /* @TODO Alerts implementation
             * 'webperf:alerts' => [
             * 'label' => Craft::t('webperf', 'Alerts'),
             * ],
             */
            'webperf:recommendations' => [
                'label' => Craft::t('webperf', 'Recommendations'),
            ],
            'webperf:sidebar' => [
                'label' => Craft::t('webperf', 'Performance Sidebar'),
            ],
            'webperf:settings' => [
                'label' => Craft::t('webperf', 'Settings'),
            ],
        ];
    }

    /**
     * Get a string value with the number of recommendations
     *
     * @return string
     */
    protected function getRecommendationsCount(): string
    {
        $cache = Craft::$app->getCache();
        // See if there are any recommendations to add as a badge
        $recommendations = $cache->getOrSet(self::RECOMMENDATIONS_CACHE_KEY, function () {
            $data = [];
            $now = new DateTime();
            $end = $now->format('Y-m-d');
            $start = $now->modify('-30 days')->format('Y-m-d');
            $stats = Webperf::$plugin->recommendations->data('', $start, $end);
            if (!empty($stats)) {
                $recSample = new RecommendationDataSample($stats);
                $data = Webperf::$plugin->recommendations->list($recSample);
            }

            return count($data);
        }, self::RECOMMENDATIONS_CACHE_DURATION);

        if (!$recommendations) {
            $recommendations = '';
        }

        return (string)$recommendations;
    }

    /**
     * Get a string value with the number of errors
     *
     * @return string
     */
    protected function getErrorsCount(): string
    {
        $cache = Craft::$app->getCache();
        // See if there are any recommendations to add as a badge
        $errors = $cache->getOrSet(self::ERRORS_CACHE_KEY, function () {
            $now = new DateTime();
            $end = $now->format('Y-m-d');
            $start = $now->modify('-30 days')->format('Y-m-d');

            return Webperf::$plugin->errorSamples->totalErrorSamplesRange(0, $start, $end);
        }, self::ERRORS_CACHE_DURATION);

        if (!$errors) {
            $errors = '';
        } else {
            $errors = '⚠';
        }

        return (string)$errors;
    }
}
