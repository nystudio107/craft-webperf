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
use nystudio107\webperf\helpers\Permission as PermissionHelper;
use nystudio107\webperf\models\RecommendationDataSample;
use nystudio107\webperf\Webperf;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class RecommendationsController extends Controller
{
    // Constants
    // =========================================================================

    // Protected Properties
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * Return a list of recommendations
     *
     * @param string $pageUrl
     * @param string $start
     * @param string $end
     * @param int $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionList(
        $pageUrl = '',
        string $start = '',
        string $end = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:recommendations');
        $data = [];
        $stats = Webperf::$plugin->recommendations->data($pageUrl, $start, $end, $siteId);
        if (!empty($stats)) {
            $recSample = new RecommendationDataSample($stats);
            $data = Webperf::$plugin->recommendations->list($recSample);
        }

        return $this->asJson($data);
    }

    // Protected Methods
    // =========================================================================
}
