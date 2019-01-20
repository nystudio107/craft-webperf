<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\controllers;

use nystudio107\webperf\Webperf;
use nystudio107\webperf\helpers\Permission as PermissionHelper;

use Craft;
use craft\web\Controller;

use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DataSamplesController extends Controller
{
    // Constants
    // =========================================================================

    // Public Methods
    // =========================================================================

    /**
     * @param int $id
     *
     * @return Response
     * @throws \craft\errors\MissingComponentException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDeleteSampleById(int $id): Response
    {
        PermissionHelper::controllerPermissionCheck('webperf:delete-data-samples');
        if (Webperf::$plugin->dataSamples->deleteSampleById($id)) {
            // Clear the caches and continue on
            Webperf::$plugin->clearAllCaches();
            Craft::$app->getSession()->setNotice(Craft::t('webperf', 'Data sample deleted.'));

            return $this->redirect(Craft::$app->getRequest()->referrer);
        }
        Craft::$app->getSession()->setError(Craft::t('webperf', "Couldn't delete data sample."));

        return $this->redirect(Craft::$app->getRequest()->referrer);
    }

    /**
     * @param string   $pageUrl
     * @param int|null $siteId
     *
     * @return Response
     * @throws \craft\errors\MissingComponentException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDeleteSamplesByUrl(string $pageUrl, int $siteId = null): Response
    {
        // We may be passed 0 or other "empty" values, so coerce to null
        if (empty($siteId)) {
            $siteId = null;
        }
        PermissionHelper::controllerPermissionCheck('webperf:delete-data-samples');
        if (Webperf::$plugin->dataSamples->deleteDataSamplesByUrl($pageUrl, $siteId)) {
            // Clear the caches and continue on
            Webperf::$plugin->clearAllCaches();
            Craft::$app->getSession()->setNotice(Craft::t('webperf', 'Data samples deleted.'));

            return $this->redirect(Craft::$app->getRequest()->referrer);
        }
        Craft::$app->getSession()->setError(Craft::t('webperf', "Couldn't delete data samples."));

        return $this->redirect(Craft::$app->getRequest()->referrer);
    }

    /**
     * @param int|null $siteId
     *
     * @return Response
     * @throws \craft\errors\MissingComponentException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDeleteAllSamples(int $siteId = null): Response
    {
        // We may be passed 0 or other "empty" values, so coerce to null
        if (empty($siteId)) {
            $siteId = null;
        }
        PermissionHelper::controllerPermissionCheck('webperf:delete-data-samples');
        if (Webperf::$plugin->dataSamples->deleteAllDataSamples($siteId)) {
            // Clear the caches and continue on
            Webperf::$plugin->clearAllCaches();
            Craft::$app->getSession()->setNotice(Craft::t('webperf', 'All data samples deleted.'));

            return $this->redirect(Craft::$app->getRequest()->referrer);
        }
        Craft::$app->getSession()->setError(Craft::t('webperf', "Couldn't delete data samples."));

        return $this->redirect(Craft::$app->getRequest()->referrer);
    }
}
