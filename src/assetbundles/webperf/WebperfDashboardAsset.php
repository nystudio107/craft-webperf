<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\assetbundles\webperf;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class WebperfDashboardAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@nystudio107/webperf/assetbundles/webperf/dist";

        $this->depends = [
            CpAsset::class,
            WebperfAsset::class,
        ];

        $this->js = [
        ];

        $this->css = [
        ];

        parent::init();
    }
}
