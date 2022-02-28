<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\recommendations;

use Craft;
use nystudio107\webperf\base\Recommendation;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class CraftTwigTime extends Recommendation
{
    // Constants
    // =========================================================================

    protected const MAX_TWIG_TIME = 1 * 1000;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate(): void
    {
        // See if there are too many database queries
        if ($this->sample->craftTwigMs >= self::MAX_TWIG_TIME) {
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'Look into decreasing the Twig template rendering time',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'The Twig templates took {displayCraftTwigMs} to render. Try to simplify the templates by doing less computation in Twig, and profiling them to see where the bottlenecks are.',
                [
                    'displayCraftTwigMs' => $this->displayMs($this->sample->craftTwigMs),
                ]
            );
            $this->learnMoreUrl = 'https://nystudio107.com/blog/profiling-your-website-with-craft-cms-3s-debug-toolbar';

            return;
        }
    }
}
