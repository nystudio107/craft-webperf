<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\models;

use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Settings extends Model
{
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
     * @var int The number of data samples to store
     */
    public $dataSamplesStoredLimit = 10000;

    /**
     * @var bool Whether the DataSamples should be trimmed after each new DataSample is added
     */
    public $automaticallyTrimDataSamples = true;

    /**
     * @var bool
     */
    public $filterBotUserAgents = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pluginName', 'string'],
            ['pluginName', 'default', 'value' => 'Webperf'],
            ['includeBeacon', 'boolean'],
            ['includeBeacon', 'default', 'value' => true],
            ['dataSamplesStoredLimit', 'integer'],
            ['dataSamplesStoredLimit', 'default', 'value' => 10000],
            ['automaticallyTrimDataSamples', 'boolean'],
            ['automaticallyTrimDataSamples', 'default', 'value' => true],
            ['filterBotUserAgents', 'boolean'],
            ['filterBotUserAgents', 'default', 'value' => true],
        ];
    }
}
