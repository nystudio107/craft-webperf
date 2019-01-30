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

use nystudio107\webperf\base\Recommendation;

use Craft;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class CraftTotalTime extends Recommendation
{
    // Constants
    // =========================================================================

    const MAX_TOTAL_TIME = 2 * 1000;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate()
    {
        // See if there are too many database queries
        if ($this->sample->craftTotalMs >= self::MAX_TOTAL_TIME) {
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'Look into utilizing the `{% cache %}` tag',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'It took Craft a total of {displayCraftTotalMs} to render. Ensure you are utilizing the `{% cache %}` tag effectively to solve concurrency issues.',
                [
                    'displayCraftTotalMs' => $this->displayMs($this->sample->craftTotalMs),
                ]
            );
            $this->learnMoreUrl = 'https://nystudio107.com/blog/the-craft-cache-tag-in-depth';

            return;
        }
    }
}
