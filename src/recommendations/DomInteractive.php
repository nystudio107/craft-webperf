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
class DomInteractive extends Recommendation
{
    // Constants
    // =========================================================================

    const MAX_DOM_INTERACTIVE_TIME = 3 * 1000;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate()
    {
        // See if there are too many database queries
        if ($this->sample->domInteractive >= self::MAX_DOM_INTERACTIVE_TIME) {
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'The time before the user can interact with the page is too long',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'The time to interactive was {displayDomInteractive}. Try to reduce this by reducing the amount of JavaScript that is executed on your page, and ensure that [Marketing Tags](https://nystudio107.com/blog/tags-gone-wild) are kept in check.',
                [
                    'displayDomInteractive' => $this->displayMs($this->sample->domInteractive),
                ]
            );
            $this->learnMoreUrl = 'https://developers.google.com/web/tools/lighthouse/audits/time-to-interactive';

            return;
        }
    }
}
