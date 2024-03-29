<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\controllers;

use craft\web\Controller;

use nystudio107\webperf\Webperf;

use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class RenderController extends Controller
{
    // Protected Properties
    // =========================================================================

    protected array|bool|int $allowAnonymous = ['amp-iframe', 'beacon-script'];

    // Public Methods
    // =========================================================================

    /**
     * @return Response The rendered result
     */
    public function actionAmpIframe(): Response
    {
        // Render the template
        return $this->asRaw(Webperf::$plugin->beacons->ampHtmlIframe());
    }

    /**
     * @param string $title
     *
     * @return Response
     */
    public function actionBeaconScript(string $title = ''): Response
    {
        return $this->asRaw(Webperf::$plugin->beacons->htmlBeaconScript(true, $title));
    }
}
