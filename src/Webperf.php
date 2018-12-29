<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf;

use nystudio107\webperf\services\Metrics as MetricsService;
use nystudio107\webperf\models\Settings;
use nystudio107\webperf\widgets\Metrics as MetricsWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Webperf
 *
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 *
 * @property  MetricsService $metrics
 */
class Webperf extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Webperf
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'webperf/metrics';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'webperf/metrics/do-something';
            }
        );

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MetricsWidget::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'webperf',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'webperf/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
