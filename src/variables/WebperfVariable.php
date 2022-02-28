<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\variables;

use nystudio107\pluginvite\variables\ViteVariableInterface;
use nystudio107\pluginvite\variables\ViteVariableTrait;
use nystudio107\webperf\Webperf;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class WebperfVariable implements ViteVariableInterface
{
    use ViteVariableTrait;

    // Public Methods
    // =========================================================================

    /**
     * Whether to include the beacon or not
     *
     * @param bool $include
     */
    public function includeBeacon(bool $include): void
    {
        Webperf::$settings->includeBeacon = $include;
    }

    /**
     * Whether to include the Craft beacon or not
     *
     * @param bool $include
     */
    public function includeCraftBeacon(bool $include): void
    {
        Webperf::$settings->includeCraftProfiling = $include;
    }

    /**
     * Change the type of render; either `html` or `amp-html` are valid for $renderType
     *
     * @param string $renderType
     */
    public function renderType(string $renderType): void
    {
        Webperf::$renderType = $renderType;
    }

    /**
     * @param int $siteId
     * @param string $column
     *
     * @return int|string
     */
    public function totalSamples(int $siteId, string $column): int|string
    {
        return Webperf::$plugin->dataSamples->totalSamples($siteId, $column);
    }

    /**
     * Get the total number of errors optionally limited by siteId, between
     * $start and $end
     *
     * @param int $siteId
     * @param string $start
     * @param string $end
     * @param string|null $pageUrl
     * @param string|null $type
     *
     * @return int
     */
    public function totalErrorSamplesRange(int $siteId, string $start, string $end, $pageUrl = null, $type = null): int
    {
        return Webperf::$plugin->errorSamples->totalErrorSamplesRange($siteId, $start, $end, $pageUrl, $type);
    }
}
