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

use nystudio107\webperf\base\DbErrorSample;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class CraftDbErrorSample extends DbErrorSample
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->type = 'craft';
    }
}
