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

use nystudio107\webperf\log\ProfileTarget;
use nystudio107\webperf\models\DataSample;
use nystudio107\webperf\models\Settings;
use nystudio107\webperf\services\DataSamples as DataSamplesService;
use nystudio107\webperf\services\Beacons as BeaconsService;
use nystudio107\webperf\variables\WebperfVariable;
use nystudio107\webperf\widgets\Metrics as MetricsWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\services\Dashboard;
use craft\services\UserPermissions;
use craft\web\Application;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\web\View;

use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * Class Webperf
 *
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 *
 * @property  DataSamplesService  $dataSamples
 * @property  BeaconsService      $beacons
 * @property  ProfileTarget       $profileTarget
 */
class Webperf extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Webperf
     */
    public static $plugin;

    /**
     * @var Settings
     */
    public static $settings;

    /**
     * @var int|null
     */
    public static $requestUuid;

    /**
     * @var int|null
     */
    public static $requestUrl;

    /**
     * @var bool
     */
    public static $beaconIncluded = false;

    /**
     * @var string
     */
    public static $renderType = 'html';

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // Initialize properties
        self::$plugin = $this;
        self::$settings = $this->getSettings();
        try {
            self::$requestUuid = random_int(0, PHP_INT_MAX);
        } catch (\Exception $e) {
            self::$requestUuid = null;
        }
        $this->name = self::$settings->pluginName;
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
    public function getCpNavItem()
    {
        $subNavs = [];
        $navItem = parent::getCpNavItem();
        $currentUser = Craft::$app->getUser()->getIdentity();
        // Only show sub-navs the user has permission to view
        if ($currentUser->can('webperf:dashboard')) {
            $subNavs['dashboard'] = [
                'label' => 'Dashboard',
                'url' => 'webperf/dashboard',
            ];
        }
        if ($currentUser->can('webperf:pages')) {
            $subNavs['pages'] = [
                'label' => 'Pages',
                'url' => 'webperf/pages',
            ];
        }
        if ($currentUser->can('webperf:settings')) {
            $subNavs['settings'] = [
                'label' => 'Settings',
                'url' => 'webperf/settings',
            ];
        }
        $navItem = array_merge($navItem, [
            'subnav' => $subNavs,
        ]);

        return $navItem;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Add in our components
     */
    protected function addComponents()
    {
        $request = Craft::$app->getRequest();
        if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest()) {
            $this->setRequestUrl();
            try {
                $uri = $request->getPathInfo();
            } catch (InvalidConfigException $e) {
                $uri = '';
            }
            // Ignore our own controllers
            if (self::$settings->includeCraftProfiling && strpos($uri, 'webperf/') !== 0) {
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
                Craft::$app->getLog()->targets['webperf'] = $this->profileTarget;
            }
        }
    }

    /**
     * Set the request URL
     *
     * @param bool $force
     */
    protected function setRequestUrl(bool $force = false)
    {
        self::$requestUrl = DataSample::PLACEHOLDER_URL;
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
    protected function installEventListeners()
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
    protected function installGlobalEventListeners()
    {
        // Handler: CraftVariable::EVENT_INIT
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('webperf', WebperfVariable::class);
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
                if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest()) {
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
    protected function installSiteEventListeners()
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
    protected function installCpEventListeners()
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
        // Handler: Dashboard::EVENT_REGISTER_WIDGET_TYPES
        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MetricsWidget::class;
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
    protected function handleSiteRequest()
    {
        // Don't include the beacon for response codes >= 400
        $response = Craft::$app->getResponse();
        if ($response->statusCode < 400) {
            // Handler: View::EVENT_END_PAGE
            Event::on(
                View::class,
                View::EVENT_END_PAGE,
                function () {
                    Craft::debug(
                        'View::EVENT_END_PAGE',
                        __METHOD__
                    );
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
            );
            // Handler: View::EVENT_END_BODY
            Event::on(
                View::class,
                View::EVENT_END_BODY,
                function () {
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
    protected function handleAdminCpRequest()
    {
    }

    /**
     * Clear all the caches!
     */
    public function clearAllCaches()
    {
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
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
            // Tables
            '/webperf/tables/pages-index' => 'webperf/tables/pages-index',
            '/webperf/tables/page-detail' => 'webperf/tables/page-detail',
            // Charts
            '/webperf/charts/dashboard-stats-average/<column:{handle}>'
            => 'webperf/charts/dashboard-stats-average',
            '/webperf/charts/dashboard-stats-average/<column:{handle}>/<siteId:\d+>'
            => 'webperf/charts/dashboard-stats-average',
            '/webperf/charts/dashboard-slowest-pages/<column:{handle}>/<limit:\d+>'
            => 'webperf/charts/dashboard-slowest-pages',
            '/webperf/charts/dashboard-slowest-pages/<column:{handle}>/<limit:\d+>/<siteId:\d+>'
            => 'webperf/charts/dashboard-slowest-pages',
            '/webperf/charts/widget/<days>' => 'webperf/charts/widget',
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

            'webperf/pages' => 'webperf/sections/pages-index',
            'webperf/pages/<siteHandle:{handle}>' => 'webperf/sections/pages-index',

            'webperf/page-detail' => 'webperf/sections/page-detail',
            'webperf/page-detail/<siteHandle:{handle}>' => 'webperf/sections/page-detail',

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
            'webperf:pages' => [
                'label' => Craft::t('webperf', 'Pages'),
            ],
            'webperf:page-detail' => [
                'label' => Craft::t('webperf', 'Page Detail'),
            ],
            'webperf:delete-data-samples' => [
                'label' => Craft::t('webperf', 'Delete Data Samples'),
            ],
            'webperf:settings' => [
                'label' => Craft::t('webperf', 'Settings'),
            ],
        ];
    }
}
