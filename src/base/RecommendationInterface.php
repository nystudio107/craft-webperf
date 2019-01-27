<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\base;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
interface RecommendationInterface
{

    // Constants
    // =========================================================================

    // Static Methods
    // =========================================================================

    // Public Methods
    // =========================================================================

    /**
     * Add data to the container. If the $key already exists, it is overwritten
     *
     * @param        $data
     * @param string $key
     */
    public function addData($data, string $key);

}
