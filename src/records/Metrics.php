<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\records;

use nystudio107\webperf\Webperf;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Metrics extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webperf_metrics}}';
    }
}
