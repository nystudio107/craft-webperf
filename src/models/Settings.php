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
use craft\behaviors\EnvAttributeParserBehavior;
use craft\validators\ArrayValidator;
use craft\validators\ColorValidator;
use putyourlightson\blitz\Blitz;
use yii\behaviors\AttributeTypecastBehavior;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Settings extends Model
{
    // Constants
    // =========================================================================

    protected const BLITZ_PLUGIN_HANDLE = 'blitz';

    // Public Properties
    // =========================================================================

    /**
     * @var string The public-facing name of the plugin
     */
    public string $pluginName = 'Webperf';

    /**
     * @var bool Whether or not to include the beacon on the page
     */
    public bool $includeBeacon = true;

    /**
     * @var bool Whether or not to include the Craft profiling of pages
     */
    public bool $includeCraftProfiling = true;

    /**
     * @var bool If the site is static cached, turn this option on to prevent Webperf from generating a unique beacon token
     */
    public bool $staticCachedSite = false;

    /**
     * @var int The number of data samples to store
     */
    public int $dataSamplesStoredLimit = 100000;

    /**
     * @var bool Whether the DataSamples should be trimmed after each new DataSample is added
     */
    public bool $automaticallyTrimDataSamples = true;

    /**
     * @var bool Whether outlier data samples that are 10x the mean should be deleted
     */
    public bool $trimOutlierDataSamples = true;

    /**
     * @var int The number of milliseconds required between trimming of data samples
     */
    public int $samplesRateLimitMs = 3600000;

    /**
     * @var int The number of milliseconds required between recording of frontend beacon data samples
     */
    public int $rateLimitMs = 500;

    /**
     * @var string API Key for WebPageTest.org
     */
    public string $webpageTestApiKey = '';

    /**
     * @var array [Regular expressions](https://regexr.com/) to match URLs to exclude from tracking
     */
    public array $excludePatterns = [
        0 => [
            'pattern' => '/webperf/.*',
        ],
        1 => [
            'pattern' => '/cpresources/.*',
        ],
        2 => [
            'pattern' => '/retour/.*',
        ],
        3 => [
            'pattern' => '/seomatic/.*',
        ],
    ];

    /**
     * @var bool Whether Craft `warning` messages should be recorded in addition to `error` messages
     */
    public bool $includeCraftWarnings = false;

    /**
     * @var int The number of error samples to store
     */
    public int $errorSamplesStoredLimit = 1000;

    /**
     * @var bool Whether the ErrorSamples should be trimmed after each new ErrorSample is added
     */
    public bool $automaticallyTrimErrorSamples = true;

    /**
     * @var bool Whether to filter bot user agents from generating profile hits or not
     *           NOT visible in the GUI currently
     */
    public bool $filterBotUserAgents = true;

    /**
     * @var bool Whether the performance summary sidebar should be shown on entry, category, and product pages
     */
    public bool $displaySidebar = true;

    /**
     * @var string The dashboard 'fast' color for charts
     */
    public string $dashboardFastColor = '#00C800';

    /**
     * @var string The dashboard 'average' color for charts
     */
    public string $dashboardAverageColor = '#FFFF00';

    /**
     * @var string The dashboard 'slow' color for charts
     */
    public string $dashboardSlowColor = '#C80000';

    // Threshold levels
    // =========================================================================

    /**
     * @var int|float Threshold in seconds for the dns metric, beyond which it will be considered slow
     */
    public int|float $dnsThreshold = 0.5;

    /**
     * @var int|float Threshold in seconds for the connect metric, beyond which it will be considered slow
     */
    public int|float $connectThreshold = 0.5;

    /**
     * @var int|float Threshold in seconds for the first byte metric, beyond which it will be considered slow
     */
    public int|float $firstByteThreshold = 2.0;

    /**
     * @var int|float Threshold in seconds for the first paint metric, beyond which it will be considered slow
     */
    public int|float $firstPaintThreshold = 5.0;

    /**
     * @var int|float Threshold in seconds for the first contentful paint metric, beyond which it will be considered slow
     */
    public int|float $firstContentfulPaintThreshold = 5.0;

    /**
     * @var int|float Threshold in seconds for the DOM interactive metric, beyond which it will be considered slow
     */
    public int|float $domInteractiveThreshold = 5.0;

    /**
     * @var int|float Threshold in seconds for the page load metric, beyond which it will be considered slow
     */
    public int|float $pageLoadThreshold = 10.0;

    /**
     * @var int|float Threshold in seconds for the Craft execution metric, beyond which it will be considered slow
     */
    public int|float $craftTotalMsThreshold = 2.0;

    /**
     * @var int|float Threshold in seconds for the database queries metric, beyond which it will be considered slow
     */
    public int|float $craftDbMsThreshold = 2.0;

    /**
     * @var int|float Threshold in seconds for the Twig rendering metric, beyond which it will be considered slow
     */
    public int|float $craftTwigMsThreshold = 2.0;

    /**
     * @var int|float Threshold in seconds for the Craft other metric, beyond which it will be considered slow
     */
    public int|float $craftOtherMsThreshold = 2.0;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        // If Blitz is installed & enabled, flip the $staticCachedSite on
        /** @var Blitz|null $blitz */
        $blitz = Craft::$app->getPlugins()->getPlugin(self::BLITZ_PLUGIN_HANDLE);
        if ($blitz && $blitz->settings->cachingEnabled) {
            $this->staticCachedSite = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
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
            ['excludePatterns', ArrayValidator::class],
            ['includeCraftWarnings', 'boolean'],
            ['errorSamplesStoredLimit', 'integer'],
            ['errorSamplesStoredLimit', 'default', 'value' => 1000],
            ['automaticallyTrimErrorSamples', 'boolean'],
            ['filterBotUserAgents', 'boolean'],
            ['displaySidebar', 'boolean'],
            ['dashboardFastColor', 'default', 'value' => '#00C800'],
            ['dashboardAverageColor', 'default', 'value' => '#FFA500'],
            ['dashboardSlowColor', 'default', 'value' => '#C80000'],
            [
                [
                    'dashboardFastColor',
                    'dashboardAverageColor',
                    'dashboardSlowColor',
                ],
                ColorValidator::class,
            ],
            [
                [
                    'dnsThreshold',
                    'connectThreshold',
                    'firstByteThreshold',
                    'firstPaintThreshold',
                    'firstContentfulPaintThreshold',
                    'domInteractiveThreshold',
                    'pageLoadThreshold',
                    'craftTotalMsThreshold',
                    'craftDbMsThreshold',
                    'craftTwigMsThreshold',
                    'craftOtherMsThreshold',
                ],
                'number',
                'min' => 0.1,
                'max' => 100,
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                // 'attributeTypes' will be composed automatically according to `rules()`
            ],
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => [
                    'webpageTestApiKey',
                ],
            ],
        ];
    }
}
