<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\helpers;

use nystudio107\minify\Minify;

use Craft;
use craft\helpers\Template;
use craft\web\View;

use yii\base\Exception;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class PluginTemplate
{
    // Constants
    // =========================================================================

    const MINIFY_PLUGIN_HANDLE = 'minify';

    // Static Methods
    // =========================================================================

    public static function renderStringTemplate(string $templateString, array $params = []): string
    {
        try {
            $html = Craft::$app->getView()->renderString($templateString, $params);
        } catch (\Exception $e) {
            $html = Craft::t(
                'webperf',
                'Error rendering template string -> {error}',
                ['error' => $e->getMessage()]
            );
            Craft::error($html, __METHOD__);
        }

        return $html;
    }

    /**
     * Render a plugin template
     *
     * @param string      $templatePath
     * @param array       $params
     * @param string|null $minifier
     *
     * @return string
     */
    public static function renderPluginTemplate(
        string $templatePath,
        array $params = [],
        string $minifier = null
    ): string {
        // Stash the old template mode, and set it Control Panel template mode
        $oldMode = Craft::$app->view->getTemplateMode();
        try {
            Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        } catch (Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        // Render the template with our vars passed in
        try {
            $htmlText = Craft::$app->view->renderTemplate('webperf/' . $templatePath, $params);
            if ($minifier) {
                // If SEOmatic is installed, get the title from it
                $minify = Craft::$app->getPlugins()->getPlugin(self::MINIFY_PLUGIN_HANDLE);
                if ($minify) {
                    $htmlText = Minify::$plugin->minify->$minifier($htmlText);
                }

            }
        } catch (\Exception $e) {
            $htmlText = Craft::t(
                'webperf',
                'Error rendering `{template}` -> {error}',
                ['template' => $templatePath, 'error' => $e->getMessage()]
            );
            Craft::error($htmlText, __METHOD__);
        }

        // Restore the old template mode
        try {
            Craft::$app->view->setTemplateMode($oldMode);
        } catch (Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        return Template::raw($htmlText);
    }
}
