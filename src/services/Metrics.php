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

use nystudio107\webperf\Webperf;

use Craft;
use craft\base\Component;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Metrics extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (Webperf::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
