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
class FirstContentfulPaint extends Recommendation
{
    // Constants
    // =========================================================================

    const MAX_FIRST_CONTENTFUL_PAINT_TIME = 3 * 1000;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate()
    {
        // See if there are too many database queries
        if ($this->sample->firstContentfulPaint >= self::MAX_FIRST_CONTENTFUL_PAINT_TIME) {
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'The wait is too long before content is displayed',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'The first contentful paint took {displayFirstContentfulPaint}. Try to avoid blocking the render by implementing [CriticalCSS](https://nystudio107.com/blog/implementing-critical-css), optimizing the [Critical Path](https://developers.google.com/web/fundamentals/performance/critical-rendering-path/) by loading JavaScript asynchronously, and using the [font-display](https://css-tricks.com/font-display-masses/) property.',
                [
                    'displayFirstContentfulPaint' => $this->displayMs($this->sample->firstContentfulPaint),
                ]
            );
            $this->learnMoreUrl = 'https://developers.google.com/web/tools/lighthouse/audits/first-contentful-paint';

            return;
        }
    }
}
