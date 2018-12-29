<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\services;

use nystudio107\webperf\Webperf;
use nystudio107\webperf\helpers\PluginTemplate;
use nystudio107\webperf\assetbundles\boomerang\BoomerangAsset;

use Craft;
use craft\base\Component;

use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Beacon extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function includeBeacon()
    {
        $view = Craft::$app->getView();
        // Asset bundle
        try {
            $view->registerAssetBundle(BoomerangAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
        $boomerangUrl = Craft::$app->assetManager->getPublishedUrl(
            '@nystudio107/webperf/assetbundles/boomerang/dist/js/boomerang-1.0.0.min.js',
            true
        );
        $script = PluginTemplate::renderPluginTemplate(
            '_frontend/scripts/load-boomerang-iframe.twig',
            [
                'boomerangScriptUrl' => $boomerangUrl,
            ]
        );
        $view->registerJs(
            $script,
            $view::POS_HEAD
        );
    }
}
