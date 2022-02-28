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
class CraftQueryCount extends Recommendation
{
    // Constants
    // =========================================================================

    protected const MAX_QUERIES = 150;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate(): void
    {
        // See if there are too many database queries
        if ($this->sample->craftDbCnt >= self::MAX_QUERIES) {
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'Look into Eager Loading to decrease database queries',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'A total of {dbQueries} database queries were executed. Look into decreasing the number of database queries needed by leveraging Eager Loading in Craft CMS.',
                [
                    'dbQueries' => round($this->sample->craftDbCnt),
                ]
            );
            $this->learnMoreUrl = 'https://nystudio107.com/blog/speed-up-your-craft-cms-templates-with-eager-loading';

            return;
        }
    }
}
