<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\events;

use nystudio107\webperf\base\DbDataSampleInterface;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DataSampleEvent extends \yii\base\ModelEvent
{
    // Properties
    // =========================================================================

    /**
     * @var bool Whether the redirect is brand new
     */
    public $isNew = false;

    /**
     * @var DbDataSampleInterface The data sample
     */
    public $dataSample;
}
