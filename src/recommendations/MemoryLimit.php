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

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class MemoryLimit extends Recommendation
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate()
    {
    }

    /**
     * @inheritdoc
     */
    public function recommendation(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function summary(): string
    {
        return 'This is a summary';
    }

    /**
     * @inheritdoc
     */
    public function detail(): string
    {
        return 'This is a detail';
    }

    /**
     * @inheritdoc
     */
    public function learnMoreLink(): string
    {
        return 'http://woof.com';
    }
}
