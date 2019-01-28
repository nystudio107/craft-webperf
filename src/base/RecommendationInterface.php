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
    // Public Methods
    // =========================================================================

    /**
     * Evaluate the passed in RecommendationDataSample
     *
     * @return void
     */
    public function evaluate();

    /**
     * Returns true if there is a recommendation to be had
     *
     * @return bool
     */
    public function recommendation(): bool;

    /**
     * Returns the summary of the recommendation
     *
     * @return string
     */
    public function summary(): string;

    /**
     * Returns a link to learn more about the recommendation
     *
     * @return string
     */
    public function learnMoreLink(): string;

    /**
     * Returns the detailed text for the recommendation
     *
     * @return string
     */
    public function detail(): string;
}
