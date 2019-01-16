<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
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
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
            [
                'label' => $templateTitle,
                'url' => UrlHelper::cpUrl('webperf/dashboard'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'dashboard';
        $variables['showWelcome'] = $showWelcome;
        $variables['settings'] = Webperf::$settings;

        // Render the template
        return $this->renderTemplate('webperf/dashboard/index', $variables);
    }

    /**
     * @param string|null $siteHandle
     * @param bool        $showWelcome
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionPagesIndex(string $siteHandle = null): Response
    {
        $variables = [];
        PermissionHelper::controllerPermissionCheck('webperf:pages');
        // Trim the statistics
        Webperf::$plugin->dataSamples->trimOrphanedSamples(1024);
        Webperf::$plugin->dataSamples->trimDataSamples();
        // Get the site to edit
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        $pluginName = Webperf::$settings->pluginName;
        $templateTitle = Craft::t('webperf', 'Pages');
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
        $variables['crumbs'] = [
            [
                'label' => $pluginName,
                'url' => UrlHelper::cpUrl('webperf'),
            ],
            [
                'label' => $templateTitle,
                'url' => UrlHelper::cpUrl('webperf/pages'),
            ],
        ];
        $variables['docTitle'] = "{$pluginName} - {$templateTitle}";
        $variables['selectedSubnavItem'] = 'pages';
        $variables['settings'] = Webperf::$settings;

        // Render the template
        return $this->renderTemplate('webperf/pages/index', $variables);
    }
}
