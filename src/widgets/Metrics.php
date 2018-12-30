<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\widgets;

use nystudio107\webperf\Webperf;
use nystudio107\webperf\assetbundles\metricswidget\MetricsWidgetAsset;

use Craft;
use craft\base\Widget;

/**
 * Webperf Widget
 *
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Metrics extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $message = 'Hello, world.';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('webperf', 'DataSamples');
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@nystudio107/webperf/assetbundles/metricswidget/dist/img/DataSamples-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            [
                ['message', 'string'],
                ['message', 'default', 'value' => 'Hello, world.'],
            ]
        );
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'webperf/_components/widgets/Metrics_settings',
            [
                'widget' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        Craft::$app->getView()->registerAssetBundle(MetricsWidgetAsset::class);

        return Craft::$app->getView()->renderTemplate(
            'webperf/_components/widgets/Metrics_body',
            [
                'message' => $this->message
            ]
        );
    }
}
