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

use nystudio107\webperf\models\RecommendationDataSample;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
trait RecommendationTrait
{
    // Public Properties
    // =========================================================================

    /**
     * The data sample to be evaluated
     *
     * @var RecommendationDataSample
     */
    public $sample;
}
