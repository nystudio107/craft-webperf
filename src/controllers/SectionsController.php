<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\controllers;

use nystudio107\webperf\Webperf;
use nystudio107\webperf\assetbundles\webperf\WebperfDashboardAsset;
use nystudio107\webperf\helpers\MultiSite as MultiSiteHelper;
use nystudio107\webperf\helpers\Permission as PermissionHelper;

use Craft;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class SectionsController extends Controller
{
    // Constants
    // =========================================================================

    const DOCUMENTATION_URL = 'https://github.com/nystudio107/craft-webperf/';

    const WEBHOOKS_PLUGIN_HANDLE = 'webhooks';

    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * @param string|null $siteHandle
     * @param bool        $showWelcome
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDashboard(string $siteHandle = null, bool $showWelcome = false): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:dashboard');
        // Trim the statistics
        Webperf::$plugin->dataSamples->trimOrphanedSamples(1024);
        Webperf::$plugin->dataSamples->trimDataSamples();
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Dashboard');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(WebperfDashboardAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/webperf/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'dashboard';
        // Basic variables
        $variables['fullPageForm'] = false;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'dashboard';
        $variables['showWelcome'] = $showWelcome;
        $variables['settings'] = Webperf::$settings;
        // Set the default date range
        $now = new \DateTime();
        $variables['end'] = $now->format('Y-m-d');
        $variables['start'] = $now->modify('-1 year')->format('Y-m-d');

        // Render the template
        return $this->renderTemplate('webperf/dashboard/index', $variables);
    }

    /**
     * @param string|null $siteHandle
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionPagesIndex(string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:performance');
        // Trim the statistics
        Webperf::$plugin->dataSamples->trimOrphanedSamples(1024);
        Webperf::$plugin->dataSamples->trimDataSamples();
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Performance');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(WebperfDashboardAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/webperf/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'performance';

        // Basic variables
        $variables['fullPageForm'] = false;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'performance';
        $variables['settings'] = Webperf::$settings;
        // Set the default date range
        $now = new \DateTime();
        $variables['end'] = $now->format('Y-m-d');
        $variables['start'] = $now->modify('-1 year')->format('Y-m-d');

        // Render the template
        return $this->renderTemplate('webperf/performance/index', $variables);
    }

    /**
     * @param string      $pageUrl
     * @param string|null $siteHandle
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionPageDetail(string $pageUrl, string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:performance-detail');
        // Trim the statistics
        Webperf::$plugin->dataSamples->trimOrphanedSamples(1024);
        Webperf::$plugin->dataSamples->trimDataSamples();
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Performance Detail');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(WebperfDashboardAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/webperf/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'performance/page-detail';

        // Basic variables
        $variables['fullPageForm'] = false;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
            [
                'label' => Craft::t('webperf', 'Performance'),
                'url' => UrlHelper::cpUrl('webperf/performance'.$siteHandleUri),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'performance';
        $variables['pageUrl'] = $pageUrl;
        $variables['pageTitle'] = Webperf::$plugin->dataSamples->pageTitle($pageUrl, $siteId);
        $variables['settings'] = Webperf::$settings;
        $variables['webpageTestApiKey'] = Webperf::$settings->webpageTestApiKey;
        if (Webperf::$craft31 && $variables['webpageTestApiKey']) {
            $variables['webpageTestApiKey'] = Craft::parseEnv($variables['webpageTestApiKey']);
        }
        // Set the default date range
        $now = new \DateTime();
        $variables['end'] = $now->format('Y-m-d');
        $variables['start'] = $now->modify('-1 year')->format('Y-m-d');

        // Render the template
        return $this->renderTemplate('webperf/performance/page-detail', $variables);
    }


    /**
     * @param string|null $siteHandle
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionErrorsIndex(string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:errors');
        // Trim the statistics
        Webperf::$plugin->errorSamples->trimErrorSamples();
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Errors');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(WebperfDashboardAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/webperf/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'errors';

        // Basic variables
        $variables['fullPageForm'] = false;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'errors';
        $variables['settings'] = Webperf::$settings;
        // Set the default date range
        $now = new \DateTime();
        $variables['end'] = $now->format('Y-m-d');
        $variables['start'] = $now->modify('-1 year')->format('Y-m-d');

        // Render the template
        return $this->renderTemplate('webperf/errors/index', $variables);
    }

    /**
     * @param string      $pageUrl
     * @param string|null $siteHandle
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionErrorsDetail(string $pageUrl, string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:errors-detail');
        // Trim the statistics
        Webperf::$plugin->errorSamples->trimErrorSamples();
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Errors Detail');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(WebperfDashboardAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/webperf/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'errors/page-detail';

        // Basic variables
        $variables['fullPageForm'] = false;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
            [
                'label' => Craft::t('webperf', 'Errors'),
                'url' => UrlHelper::cpUrl('webperf/errors'.$siteHandleUri),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'errors';
        $variables['pageUrl'] = $pageUrl;
        $variables['pageTitle'] = Webperf::$plugin->errorSamples->pageTitle($pageUrl, $siteId);
        $variables['settings'] = Webperf::$settings;
        // Set the default date range
        $now = new \DateTime();
        $variables['end'] = $now->format('Y-m-d');
        $variables['start'] = $now->modify('-1 year')->format('Y-m-d');

        // Render the template
        return $this->renderTemplate('webperf/errors/page-detail', $variables);
    }

    /**
     * @param string|null $siteHandle
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionAlerts(string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:alerts');
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Alerts');
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(WebperfDashboardAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/webperf/dist',
            true
        );
        // Enabled sites
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'alerts';
        // Basic variables
        $variables['fullPageForm'] = true;
        $variables['docsUrl'] = self::DOCUMENTATION_URL;
        $variables['pluginName'] = $pluginName;
        $variables['title'] = $templateTitle;
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'alerts';
        $variables['settings'] = Webperf::$settings;
        $variables['webhooks'] = Craft::$app->getPlugins()->getPlugin(self::WEBHOOKS_PLUGIN_HANDLE);

        // Render the template
        return $this->renderTemplate('webperf/alerts/index', $variables);
    }
}
