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
abstract class Recommendation extends FluentModel implements RecommendationInterface
{
    // Traits
    // =========================================================================

    use RecommendationTrait;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->sample) {
            $this->evaluate();
        }
    }
}
