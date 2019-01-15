<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\variables;

use nystudio107\webperf\Webperf;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class WebperfVariable extends ManifestVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whether to include the beacon or not
     *
     * @param bool $includeBeacon
     */
    public function includeBeacon(bool $includeBeacon)
    {
        Webperf::$settings->includeBeacon = $includeBeacon;
    }

    /**
     * Change the type of render; either `html` or `amp-html` are valid for $renderType
     *
     * @param string $renderType
     */
    public function renderType(string $renderType)
    {
        Webperf::$renderType = $renderType;
    }

    /**
     * @param int    $siteId
     * @param string $column
     *
     * @return int|string
     */
    public function totalSamples(int $siteId, string $column)
    {
        return Webperf::$plugin->dataSamples->totalSamples($siteId, $column);
    }

}
