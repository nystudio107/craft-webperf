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
class FirstByte extends Recommendation
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
        if ($this->sample->firstByte >= self::MAX_TOTAL_TIME) {
            $displayFirstByte = ($this->sample->firstByte / 1000) . 's';
            $this->hasRecommendation = true;
            $this->summary = Craft::t(
                'webperf',
                'The Time To First Byte (TTFB) is high',
                []
            );
            $this->detail = Craft::t(
                'webperf',
                'The time it took for the client to receive the first byte of data from the server was {displayFirstByte}. Look into decreasing that via the `{% cache %}` tag or some kind of static caching such as the [Blitz](https://github.com/putyourlightson/craft-blitz) plugin, [FastCGI Cache](https://nystudio107.com/blog/static-caching-with-craft-cms), or [Varnish](https://supercool.github.io/2015/06/08/making-craft-sing-with-varnish-and-nginx.html).',
                [
                    'displayFirstByte' => $displayFirstByte,
                ]
            );
            $this->learnMoreUrl = 'https://craftcms.com/guides/why-is-my-site-slow';

            return;
        }
    }
}
