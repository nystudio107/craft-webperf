<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\services;

use nystudio107\webperf\helpers\PluginTemplate;

use Craft;
use craft\base\Component;
use craft\helpers\UrlHelper;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Beacons extends Component
{
    // Constants
    // =========================================================================

    const AMP_IFRAME_SCRIPT_URL = "https://cdn.ampproject.org/v0/amp-iframe-0.1.js";

    // Public Methods
    // =========================================================================

    /*
     * @return void
     */
    public function includeHtmlBeacon()
    {
        $view = Craft::$app->getView();
        $boomerangUrl = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/boomerang/dist/js/boomerang-1.0.0.min.js',
            true
        );
        $script = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/load-boomerang-iframe.twig',
            [
                'boomerangScriptUrl' => $boomerangUrl,
            ]
        );
        $view->registerJs(
            $script,
            $view::POS_HEAD
        );
    }

    /*
     * @return void
     */
    public function includeAmpHtmlScript()
    {
        $view = Craft::$app->getView();
        $view->registerJsFile(
            self::AMP_IFRAME_SCRIPT_URL,
            [
                'position' => $view::POS_HEAD,
                'async' => 'async',
                'custom-element' => 'amp-iframe',
            ],
            'webperf-amp-iframe-script'
        );
    }

    /*
     * @return void
     */
    public function includeAmpHtmlBeacon()
    {
        $html = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/load-boomerang-amp-iframe.twig',
            [
                'boomerangIframeUrl' => UrlHelper::siteUrl('/webperf/render/amp-iframe'),
            ]
        );
        echo $html;
    }

    /*
     * @return void
     */
    public function ampHtmlIframe()
    {
        $boomerangUrl = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/boomerang/dist/js/boomerang-1.0.0.min.js',
            true
        );
        $html = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/boomerang-amp-iframe-html.twig',
            [
                'boomerangScriptUrl' => $boomerangUrl,
            ]
        );

        return $html;
    }

}
