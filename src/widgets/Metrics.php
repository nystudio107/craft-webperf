<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\widgets;

use Craft;
use craft\base\Widget;
use nystudio107\webperf\assetbundles\metricswidget\MetricsWidgetAsset;

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
    public static function iconPath(): false|string
    {
        return Craft::getAlias("@nystudio107/webperf/assetbundles/metricswidget/dist/img/DataSamples-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan(): ?int
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
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
    public function getSettingsHtml(): string
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
    public function getBodyHtml(): string
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
