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
class CraftQueryTime extends Recommendation
{
    // Constants
    // =========================================================================

    const MAX_QUERY_TIME = 1 * 1000;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate()
    {
        // See if there are too many database queries
        if ($this->sample->craftDbMs >= self::MAX_QUERY_TIME) {
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'Look into decreasing the time database queries are taking',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'The database queries took {displayCraftDbMs} to execute. Try to simplify the database queries, or leverage Eager Loading in Craft to speed them up.',
                [
                    'displayCraftDbMs' => $this->displayMs($this->sample->craftDbMs),
                ]
            );
            $this->learnMoreUrl = 'https://nystudio107.com/blog/speed-up-your-craft-cms-templates-with-eager-loading';

            return;
        }
    }
}
