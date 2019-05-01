<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

/**
 * Webperf config.php
 *
 * This file exists only as a template for the Webperf settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'webperf.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [

    /**
     * @var string The public-facing name of the plugin
     */
    'pluginName' => 'Webperf',

    /**
     * @var bool Whether or not to include the beacon on the page
     */
    'includeBeacon' => true,

    /**
     * @var bool Whether or not to include the Craft profiling of pages
     */
    'includeCraftProfiling' => true,

    /**
     * @var bool If the site is static cached, turn this option on to prevent Webperf from generating a unique beacon token
     */
    'staticCachedSite' => false,

    /**
     * @var int The number of data samples to store
     */
    'dataSamplesStoredLimit' => 100000,

    /**
     * @var bool Whether the DataSamples should be trimmed after each new DataSample is added
     */
    'automaticallyTrimDataSamples' => true,

    /**
     * @var bool Whether outlier data samples that are 10x the mean should be deleted
     */
    'trimOutlierDataSamples' => true,

    /**
     * @var int The number of milliseconds required between trimming of data samples
     */
    'samplesRateLimitMs' => 3600000,

    /**
     * @var int The number of milliseconds required between recording of frontend beacon data samples
     */
    'rateLimitMs' => 500,

    /**
     * @var string API Key for WebPageTest.org
     */
    'webpageTestApiKey' => '',

    /**
     * @var array [Regular expressions](https://regexr.com/) to match URLs to exclude from tracking
     */
    'excludePatterns' => [
        0 => [
            'pattern' => '/webperf/.*',
        ],
        1 => [
            'pattern' => '/cpresources/.*',
        ],
    ],

    /**
     * @var bool Whether Craft `warning` messages should be recorded in addition to `error` messages
     */
    'includeCraftWarnings' => false,

    /**
     * @var int The number of error samples to store
     */
    'errorSamplesStoredLimit' => 1000,

    /**
     * @var bool Whether the ErrorSamples should be trimmed after each new ErrorSample is added
     */
    'automaticallyTrimErrorSamples' => true,

    /**
     * @var bool Whether to filter bot user agents from generating profile hits or not
     *           NOT visible in the GUI currently
     */
    'filterBotUserAgents' => true,

    /**
     * @var bool Whether the performance summary sidebar should be shown on entry, category, and product pages
     */
    'displaySidebar' => true,

    /**
     * @var string The dashboard 'fast' color for charts
     */
    'dashboardFastColor' => '#00C800',

    /**
     * @var string The dashboard 'average' color for charts
     */
    'dashboardAverageColor' => '#FFFF00',

    /**
     * @var string The dashboard 'slow' color for charts
     */
    'dashboardSlowColor' => '#C80000',

        // Threshold levels
    // =========================================================================

    /**
     * @var int Threshold in seconds for the dns metric, beyond which it will be considered slow
     */
    'dnsThreshold' => 0.5,

    /**
     * @var int Threshold in seconds for the connect metric, beyond which it will be considered slow
     */
    'connectThreshold' => 0.5,

    /**
     * @var int Threshold in seconds for the first byte metric, beyond which it will be considered slow
     */
    'firstByteThreshold' => 2.0,

    /**
     * @var int Threshold in seconds for the first paint metric, beyond which it will be considered slow
     */
    'firstPaintThreshold' => 5.0,

    /**
     * @var int Threshold in seconds for the first contentful paint metric, beyond which it will be considered slow
     */
    'firstContentfulPaintThreshold' => 5.0,

    /**
     * @var int Threshold in seconds for the DOM interactive metric, beyond which it will be considered slow
     */
    'domInteractiveThreshold' => 5.0,

    /**
     * @var int Threshold in seconds for the page load metric, beyond which it will be considered slow
     */
    'pageLoadThreshold' => 10.0,

    /**
     * @var int Threshold in seconds for the Craft execution metric, beyond which it will be considered slow
     */
    'craftTotalMsThreshold' => 2.0,

    /**
     * @var int Threshold in seconds for the database queries metric, beyond which it will be considered slow
     */
    'craftDbMsThreshold' => 2.0,

    /**
     * @var int Threshold in seconds for the Twig rendering metric, beyond which it will be considered slow
     */
    'craftTwigMsThreshold' => 2.0,

    /**
     * @var int Threshold in seconds for the Craft other metric, beyond which it will be considered slow
     */
    'craftOtherMsThreshold' => 2.0,

];
