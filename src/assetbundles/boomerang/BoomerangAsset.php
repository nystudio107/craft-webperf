<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\assetbundles\Webperf;

use Craft;
use craft\web\AssetBundle;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class WebperfAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@nystudio107/webperf/assetbundles/boomerang/dist";

        $this->js = [
            'js/boomerang-1.0.0.min.js',
        ];

        parent::init();
    }
}
