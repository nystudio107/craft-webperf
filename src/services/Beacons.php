<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\services;

use nystudio107\webperf\Webperf;
use nystudio107\webperf\base\CraftDataSample;
use nystudio107\webperf\helpers\MultiSite;
use nystudio107\webperf\helpers\PluginTemplate;
use nystudio107\webperf\models\CraftDbErrorSample;
use nystudio107\webperf\models\CraftDbDataSample;

use nystudio107\seomatic\Seomatic;

use Jaybizzle\CrawlerDetect\CrawlerDetect;

use Craft;
use craft\base\Component;
use craft\errors\SiteNotFoundException;
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

    /**
     * @return void
     */
    public function includeHtmlBeacon()
    {
        $view = Craft::$app->getView();
        $script = $this->htmlBeaconScript(false);
        // Register the JavaScript
        $view->registerJs(
            $script,
            $view::POS_HEAD
        );
    }

    /**
     * @param bool        $headless
     * @param string|null $title
     *
     * @return string
     */
    public function htmlBeaconScript(bool $headless = false, string $title = null): string
    {
        $boomerangUrl = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/boomerang/dist/js/boomerang-1.0.0.min.js',
            true
        );
        $boomerangTitle = $title ?? $this->getDocumentTitle();
        $boomerangRequestId = Webperf::$settings->staticCachedSite ? null : Webperf::$requestUuid;
        $script = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/load-boomerang-iframe.twig',
            [
                'headless' => $headless,
                'boomerangScriptUrl' => $boomerangUrl,
                'boomerangTitle' => $boomerangTitle,
                'boomerangRequestId' => $boomerangRequestId,
            ],
            'jsMin'
        );

        return $script;
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
            ],
            'minify'
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
        $boomerangTitle = $this->getDocumentTitle();
        $boomerangRequestId = Webperf::$settings->staticCachedSite ? null : Webperf::$requestUuid;
        $html = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/boomerang-amp-iframe-html.twig',
            [
                'boomerangScriptUrl' => $boomerangUrl,
                'boomerangTitle' => $boomerangTitle,
                'boomerangRequestId' => $boomerangRequestId,
            ],
            'minify'
        );

        return $html;
    }

    /**
     * @return void
     */
    public function includeCraftBeacon()
    {
        // Filter out bot/spam requests via UserAgent
        if (Webperf::$settings->filterBotUserAgents) {
            $crawlerDetect = new CrawlerDetect;
            // Check the user agent of the current 'visitor'
            if ($crawlerDetect->isCrawler()) {
                return;
            }
        }
        $url = Webperf::$requestUrl ?? CraftDataSample::PLACEHOLDER_URL;
        // Get the site id
        try {
            $site = MultiSite::getSiteFromUrl($url);
            $siteId = $site->id;
        } catch (SiteNotFoundException $e) {
            $siteId = null;
        }
        $stats = Webperf::$plugin->profileTarget->stats;
        $request = Craft::$app->getRequest();
        $pageLoad = (int)($stats['database']['duration']
            + $stats['twig']['duration']
            + $stats['other']['duration']);
        // Allocate a new DataSample, and fill it in
        $sample = new CraftDbDataSample([
            'requestId' => Webperf::$requestUuid,
            'siteId' => $siteId,
            'url' => $url,
            'title' => $this->getDocumentTitle(),
            'queryString' => $request->getQueryString(),
            'pageLoad' => $pageLoad,
            'craftTotalMs' => $pageLoad,
            'craftDbMs' => (int)$stats['database']['duration'],
            'craftDbCnt' => (int)$stats['database']['count'],
            'craftTwigMs' => (int)$stats['twig']['duration'],
            'craftTwigCnt' => (int)$stats['twig']['count'],
            'craftOtherMs' => (int)$stats['other']['duration'],
            'craftOtherCnt' => (int)$stats['other']['count'],
            'craftTotalMemory' => (int)($stats['database']['memory']
                + $stats['twig']['memory']
                + $stats['other']['memory']),
        ]);
        // Save the data sample
        Craft::debug('Saving Craft DataSample: '.print_r($sample->getAttributes(), true), __METHOD__);
        Webperf::$plugin->dataSamples->addDataSample($sample);
    }

    /**
     * @return void
     */
    public function includeCraftErrorsBeacon()
    {
        // Filter out bot/spam requests via UserAgent
        if (Webperf::$settings->filterBotUserAgents) {
            $crawlerDetect = new CrawlerDetect;
            // Check the user agent of the current 'visitor'
            if ($crawlerDetect->isCrawler()) {
                return;
            }
        }
        $request = Craft::$app->getRequest();
        $url = UrlHelper::stripQueryString(
            urldecode($request->getAbsoluteUrl())
        );
        // Get the site id
        try {
            $site = MultiSite::getSiteFromUrl($url);
            $siteId = $site->id;
        } catch (SiteNotFoundException $e) {
            $siteId = null;
        }
        $messages = Webperf::$plugin->errorsTarget->pageErrors;
        // Allocate a new ErrorSample, and fill it in
        $sample = new CraftDbErrorSample([
            'requestId' => Webperf::$requestUuid,
            'siteId' => $siteId,
            'url' => $url,
            'queryString' => $request->getQueryString(),
            'title' => $this->getDocumentTitle(),
            'pageErrors' => $messages,
        ]);
        // Save the error sample
        Craft::debug('Saving Craft ErrorSample: '.print_r($sample->getAttributes(), true), __METHOD__);
        Webperf::$plugin->errorSamples->addErrorSample($sample);
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
        if (empty($docTitle)) {
            $docTitle = '';
        }
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
