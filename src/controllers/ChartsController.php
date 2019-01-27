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

use nystudio107\webperf\helpers\Permission as PermissionHelper;

use Craft;
use craft\db\Query;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class ChartsController extends Controller
{
    // Constants
    // =========================================================================

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array
     */
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * The Dashboard stats average chart
     *
     * @param string $start
     * @param string $end
     * @param string $column
     * @param string $pageUrl
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionDashboardStatsAverage(
        string $start,
        string $end,
        string $column = 'pageLoad',
        $pageUrl = '',
        int $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:dashboard');
        $data = [];
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        $pageUrl = urldecode($pageUrl);
        // Different dbs do it different ways
        $stats = null;
        $db = Craft::$app->getDb();
        if ($db->getIsMysql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'COUNT(url) AS cnt',
                    'AVG('.$column.') AS avg',
                ])
                ->where(['between', 'dateUpdated', $start, $end])
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            if ($pageUrl !== '') {
                $query->andWhere(['url' => $pageUrl]);
            }
            $stats = $query->all();
        }
        if ($db->getIsPgsql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'AVG("'.$column.'") AS avg',
                ])
                ->where(['between', 'dateUpdated', $start, $end])
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $stats = $query->all();
        }
        // Massage the data
        if ($stats) {
            foreach ($stats as &$stat) {
                $stat['cnt'] = (int)$stat['cnt'];
            }
            $data = $stats[0];
        }

        return $this->asJson($data);
    }

    /**
     * The Dashboard stats slowest pages list
     *
     * @param string $start
     * @param string $end
     * @param string $column
     * @param int    $limit
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionDashboardSlowestPages(
        string $start,
        string $end,
        string $column = 'pageLoad',
        int $limit = 3,
        int $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:dashboard');
        $data = [];
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        // Different dbs do it different ways
        $stats = null;
        $db = Craft::$app->getDb();
        if ($db->getIsMysql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'url',
                    'MIN(title) AS title',
                    'COUNT(url) AS cnt',
                    'AVG('.$column.') AS avg',
                ])
                ->where(['between', 'dateUpdated', $start, $end])
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $query
                ->orderBy('avg DESC')
                ->groupBy('url')
                ->limit($limit);
            $stats = $query->all();
        }
        if ($db->getIsPgsql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'url',
                    'MIN("title") AS title',
                    'COUNT(url) AS cnt',
                    'AVG("'.$column.'") AS avg',
                ])
                ->where(['between', 'dateUpdated', $start, $end])
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $query
                ->orderBy('avg DESC')
                ->groupBy('url')
                ->limit($limit);
            $stats = $query->all();
        }
        // Massage the data
        if ($stats) {
            foreach ($stats as &$stat) {
                $stat['cnt'] = (int)$stat['cnt'];
                $stat['detailPageUrl'] = UrlHelper::cpUrl('webperf/page-detail', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId,
                ]);
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
            }
            $data = $stats;
        }

        return $this->asJson($data);
    }

    /**
     * The Dashboard stats average chart
     *
     * @param string $start
     * @param string $end
     * @param string $pageUrl
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionPagesAreaChart(
        string $start,
        string $end,
        $pageUrl = '',
        int $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:dashboard');
        $data = [];
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        $pageUrl = urldecode($pageUrl);
        $dateStart = new \DateTime($start);
        $dateEnd = new \DateTime($end);
        $interval = date_diff($dateStart, $dateEnd);
        $dateFormat = '"%Y-%m-%d %l%p:%i"';
        if ($interval->days > 1) {
            $dateFormat = '"%Y-%m-%d %l%p"';
        }
        if ($interval->days > 30) {
            $dateFormat = '"%Y-%m-%d"';
        }
        // Different dbs do it different ways
        $stats = null;
        $db = Craft::$app->getDb();
        if ($db->getIsMysql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'AVG(pageLoad) AS pageLoad',
                    'AVG(domInteractive) AS domInteractive',
                    'AVG(firstContentfulPaint) AS firstContentfulPaint',
                    'AVG(firstPaint) AS firstPaint',
                    'AVG(firstByte) AS firstByte',
                    'AVG(connect) AS connect',
                    'AVG(dns) AS dns',
                    'AVG(craftTotalMs) AS craftTotalMs',
                    'AVG(craftTwigMs) AS craftTwigMs',
                    'AVG(craftDbMs) AS craftDbMs',
                    'DATE_FORMAT(dateUpdated, '.$dateFormat.') AS sampleDate',
                ])
                ->where(['between', 'dateUpdated', $start, $end])
                ;
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            if ($pageUrl !== '') {
                $query->andWhere(['url' => $pageUrl]);
            }
            $stats = $query
                ->groupBy('sampleDate')
                ->all();
        }
        if ($db->getIsPgsql()) {
        }
        // Massage the data
        if ($stats) {
            $data[] = [
                'name' => 'Database Queries',
                'data' => ArrayHelper::getColumn($stats, 'craftDbMs'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'Twig Rendering',
                'data' => ArrayHelper::getColumn($stats, 'craftTwigMs'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'Craft Rendering',
                'data' => ArrayHelper::getColumn($stats, 'craftTotalMs'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'DNS Lookup',
                'data' => ArrayHelper::getColumn($stats, 'dns'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'Connect',
                'data' => ArrayHelper::getColumn($stats, 'connect'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'First Byte',
                'data' => ArrayHelper::getColumn($stats, 'firstByte'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'First Paint',
                'data' => ArrayHelper::getColumn($stats, 'firstPaint'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'First Contentful Paint',
                'data' => ArrayHelper::getColumn($stats, 'firstContentfulPaint'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'DOM Interactive',
                'data' => ArrayHelper::getColumn($stats, 'domInteractive'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
            $data[] = [
                'name' => 'Page Load',
                'data' => ArrayHelper::getColumn($stats, 'pageLoad'),
                'labels' => ArrayHelper::getColumn($stats, 'sampleDate'),
            ];
        }

        return $this->asJson($data);
    }

    /**
     * The Dashboard chart
     *
     * @param int $days
     *
     * @return Response
     */
    public function actionWidget($days = 1): Response
    {
        $data = [];
        return $this->asJson($data);
    }

    // Protected Methods
    // =========================================================================
}
