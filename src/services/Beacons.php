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

use nystudio107\seomatic\Seomatic;

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
    const SEOMATIC_PLUGIN_HANDLE = 'seomatic';

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
        $boomerangTitle = $this->getDocumentTitle();
        $script = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/load-boomerang-iframe.twig',
            [
                'boomerangScriptUrl' => $boomerangUrl,
                'boomerangTitle' => $boomerangTitle,
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

    // Protected Methods
    // =========================================================================

    /**
     * Get the title of the currently rendering document
     *
     * @return string
     */
    protected function getDocumentTitle(): string
    {
        // Default to whatever the view title is
        $view = Craft::$app->getView();
        $docTitle = $view->title;
        // If SEOmatic is installed, get the title from it
        $seomatic = Craft::$app->getPlugins()->getPlugin(self::SEOMATIC_PLUGIN_HANDLE);
        if ($seomatic && Seomatic::$settings->renderEnabled) {
            $titleTag = Seomatic::$plugin->title->get('title');
            if ($titleTag) {
                $titleArray = $titleTag->renderAttributes();
                if (!empty($titleArray['title'])) {
                    $docTitle = $titleArray['title'];
                }
            }
        }

        return $docTitle;
    }
}
