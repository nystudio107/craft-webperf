<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\models;

use Craft;
use craft\base\Model;
use craft\validators\ColorValidator;

use putyourlightson\blitz\Blitz;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Settings extends Model
{
    // Constants
    // =========================================================================

    const BLITZ_PLUGIN_HANDLE = 'blitz';

    // Public Properties
    // =========================================================================

    /**
     * @var string The public-facing name of the plugin
     */
    public $pluginName = 'Webperf';

    /**
     * @var bool Whether or not to include the beacon on the page
     */
    public $includeBeacon = true;

    /**
     * @var bool Whether or not to include the Craft profiling of pages
     */
    public $includeCraftProfiling = true;

    /**
     * @var bool If the site is static cached, turn this option on to prevent Webperf from generating a unique beacon token
     */
    public $staticCachedSite = false;

    /**
     * @var int The number of data samples to store
     */
    public $dataSamplesStoredLimit = 100000;

    /**
     * @var bool Whether the DataSamples should be trimmed after each new DataSample is added
     */
    public $automaticallyTrimDataSamples = true;

    /**
     * @var bool Whether outlier data samples that are 10x the mean should be deleted
     */
    public $trimOutlierDataSamples = true;

    /**
     * @var int The number of milliseconds required between recording of frontend beacon data samples
     */
    public $rateLimitMs = 500;

    /**
     * @var string API Key for WebPageTest.org
     */
    public $webpageTestApiKey = '';

    /**
     * @var int The number of error samples to store
     */
    public $errorSamplesStoredLimit = 1000;

    /**
     * @var bool Whether the ErrorSamples should be trimmed after each new ErrorSample is added
     */
    public $automaticallyTrimErrorSamples = true;

    /**
     * @var bool Whether to filter bot user agents from generating profile hits or not
     *           NOT visible in the GUI currently
     */
    public $filterBotUserAgents = true;

    /**
     * @var string The dashboard 'fast' color for charts
     */
    public $dashboardFastColor = '#00C800';

    /**
     * @var string The dashboard 'average' color for charts
     */
    public $dashboardAverageColor = '#FFFF00';

    /**
     * @var string The dashboard 'slow' color for charts
     */
    public $dashboardSlowColor = '#C80000';

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        // If Blitz is installed & enabled, flip the $staticCachedSite on
        $blitz = Craft::$app->getPlugins()->getPlugin(self::BLITZ_PLUGIN_HANDLE);
        if ($blitz && Blitz::$plugin->getSettings()->cachingEnabled) {
            $this->staticCachedSite = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pluginName', 'string'],
            ['pluginName', 'default', 'value' => 'Webperf'],
            ['includeBeacon', 'boolean'],
            ['includeCraftProfiling', 'boolean'],
            ['staticCachedSite', 'boolean'],
            ['dataSamplesStoredLimit', 'integer'],
            ['dataSamplesStoredLimit', 'default', 'value' => 100000],
            ['automaticallyTrimDataSamples', 'boolean'],
            ['trimOutlierDataSamples', 'boolean'],
            ['rateLimitMs', 'integer'],
            ['rateLimitMs', 'default', 'value' => 500],
            ['webpageTestApiKey', 'string'],
            ['errorSamplesStoredLimit', 'integer'],
            ['errorSamplesStoredLimit', 'default', 'value' => 1000],
            ['automaticallyTrimErrorSamples', 'boolean'],
            ['filterBotUserAgents', 'boolean'],
            ['dashboardFastColor', 'default', 'value' => '#00C800'],
            ['dashboardAverageColor', 'default', 'value' => '#FFA500'],
            ['dashboardSlowColor', 'default', 'value' => '#C80000'],
            [
                [
                    'dashboardFastColor',
                    'dashboardAverageColor',
                    'dashboardSlowColor',
                ],
                ColorValidator::class
            ],
        ];
    }
}
