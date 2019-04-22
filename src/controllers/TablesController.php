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
use craft\helpers\DateTimeHelper;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class TablesController extends Controller
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
     * Handle requests for the performance index table
     *
     * @param string $sort
     * @param int    $page
     * @param int    $per_page
     * @param string $filter
     * @param string $start
     * @param string $end
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionPagesIndex(
        string $start = '',
        string $end = '',
        string $sort = 'pageLoad|DESC',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:performance');
        $data = [];
        $sortField = 'pageLoad';
        $sortType = 'DESC';
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        // Figure out the sorting type
        if ($sort !== '') {
            if (strpos($sort, '|') === false) {
                $sortField = $sort;
            } else {
                list($sortField, $sortType) = explode('|', $sort);
            }
        }
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->select([
                '[[url]]',
                'MIN([[title]]) AS [[title]]',
                'COUNT([[url]]) AS [[cnt]]',
                'AVG([[pageLoad]]) AS [[pageLoad]]',
                'AVG([[domInteractive]]) AS [[domInteractive]]',
                'AVG([[firstContentfulPaint]]) AS [[firstContentfulPaint]]',
                'AVG([[firstPaint]]) AS [[firstPaint]]',
                'AVG([[firstByte]]) AS [[firstByte]]',
                'AVG([[connect]]) AS [[connect]]',
                'AVG([[dns]]) AS [[dns]]',
                'AVG([[craftTotalMs]]) AS [[craftTotalMs]]',
                'AVG([[craftDbCnt]]) AS [[craftDbCnt]]',
                'AVG([[craftDbMs]]) AS [[craftDbMs]]',
                'AVG([[craftTwigCnt]]) AS [[craftTwigCnt]]',
                'AVG([[craftTwigMs]]) AS [[craftTwigMs]]',
                'AVG([[craftTotalMemory]]) AS [[craftTotalMemory]]',
            ])
            ->from(['{{%webperf_data_samples}}'])
            ->offset($offset)
            ->where(['between', 'dateCreated', $start, $end])
        ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query
                ->andWhere(['like', 'url', $filter])
                ->orWhere(['like', 'title', $filter])
            ;
        }
        $query
            ->orderBy("[[{$sortField}]] {$sortType}")
            ->groupBy('url')
            ->limit($per_page)
        ;

        $stats = $query->all();
        if ($stats) {
            $user = Craft::$app->getUser()->getIdentity();
            // Compute the largest page load time
            $maxTotalPageLoad = 0;
            foreach ($stats as &$stat) {
             // Determine the stat type
                if (!empty($stat['pageLoad']) && !empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'both';
                }
                if (empty($stat['firstByte'])) {
                    $stat['type'] = 'craft';
                }
                if (empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'frontend';
                }
                if ($stat['pageLoad'] > $maxTotalPageLoad) {
                    $maxTotalPageLoad = $stat['pageLoad'];
                }
            }
            // Massage the stats
            $index = 1;
            foreach ($stats as &$stat) {
                $stat['id'] = $index++;
                $stat['cnt'] = (int)$stat['cnt'];
                $stat['maxTotalPageLoad'] = (int)$maxTotalPageLoad;
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
                // Set up the appropriate helper links
                $stat['deleteLink'] = UrlHelper::actionUrl('webperf/data-samples/delete-samples-by-url', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId
                ]);
                $stat['detailPageUrl'] = UrlHelper::cpUrl('webperf/performance/page-detail', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId,
                ]);
                // Override based on permissions
                if (!$user->can('webperf:delete-data-samples')) {
                    $stat['deleteLink'] = '';
                }
                if (!$user->can('webperf:performance-detail')) {
                    $stat['detailPageUrl'] = '';
                }
            }
            // Format the data for the API
            $data['data'] = $stats;
            $query = (new Query())
                ->select(['[[url]]'])
                ->from(['{{%webperf_data_samples}}'])
                ->groupBy('[[url]]')
                ->where(['between', 'dateCreated', $start, $end])
                ;
            if ($filter !== '') {
                $query->andWhere(['like', 'url', $filter]);
                $query->orWhere(['like', 'title', $filter]);
            }
            $count = $query->count();
            $data['links']['pagination'] = [
                'total' => $count,
                'per_page' => $per_page,
                'current_page' => $page,
                'last_page' => ceil($count / $per_page),
                'next_page_url' => null,
                'prev_page_url' => null,
                'from' => $offset + 1,
                'to' => $offset + ($count > $per_page ? $per_page : $count),
            ];
        }

        return $this->asJson($data);
    }

    /**
     * Handle requests for the performance detail table
     *
     * @param string $sort
     * @param int    $page
     * @param int    $per_page
     * @param string $filter
     * @param string $pageUrl
     * @param string $start
     * @param string $end
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionPageDetail(
        string $start = '',
        string $end = '',
        string $sort = 'pageLoad|DESC',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $pageUrl = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:performance');
        $data = [];
        $sortField = 'pageLoad';
        $sortType = 'DESC';
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        $pageUrl = urldecode($pageUrl);
        // Figure out the sorting type
        if ($sort !== '') {
            if (strpos($sort, '|') === false) {
                $sortField = $sort;
            } else {
                list($sortField, $sortType) = explode('|', $sort);
            }
        }
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->from(['{{%webperf_data_samples}}'])
            ->offset($offset)
            ->where(['url' => $pageUrl])
            ->andWhere(['between', 'dateCreated', $start, $end])
        ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query
                ->andWhere(['like', 'device', $filter])
                ->orWhere(['like', 'os', $filter])
                ->orWhere(['like', 'browser', $filter])
                ->orWhere(['like', 'countryCode', $filter])
            ;
        }
        $query
            ->orderBy("{$sortField} {$sortType}")
            ->limit($per_page)
        ;
        $stats = $query->all();
        if ($stats) {
            $user = Craft::$app->getUser()->getIdentity();
            // Compute the largest page load time
            $maxTotalPageLoad = 0;
            foreach ($stats as &$stat) {
                // Determine the stat type
                if (!empty($stat['pageLoad']) && !empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'both';
                }
                if (empty($stat['firstByte'])) {
                    $stat['type'] = 'craft';
                }
                if (empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'frontend';
                }
                if ($stat['pageLoad'] > $maxTotalPageLoad) {
                    $maxTotalPageLoad = (int)$stat['pageLoad'];
                }
            }
            // Massage the stats
            foreach ($stats as &$stat) {
                if (!empty($stats['dateCreated'])) {
                    $date = DateTimeHelper::toDateTime($stats['dateCreated']);
                    $stats['dateCreated'] = $date->format('Y-m-d H:i:s');
                }
                $stat['mobile'] = (bool)$stat['mobile'];
                $stat['maxTotalPageLoad'] = (int)$maxTotalPageLoad;
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
                $stat['deleteLink'] = UrlHelper::actionUrl('webperf/data-samples/delete-sample-by-id', [
                    'id' => $stat['id']
                ]);
                // Override based on permissions
                if (!$user->can('webperf:delete-data-samples')) {
                    $stat['deleteLink'] = '';
                }
            }
            // Format the data for the API
            $data['data'] = $stats;
            $query = (new Query())
                ->select(['[[url]]'])
                ->from(['{{%webperf_data_samples}}'])
                ->where(['url' => $pageUrl])
                ->andWhere(['between', 'dateCreated', $start, $end])
            ;
            if ($filter !== '') {
                $query
                    ->andWhere(['like', 'device', $filter])
                    ->orWhere(['like', 'os', $filter])
                    ->orWhere(['like', 'browser', $filter])
                    ->orWhere(['like', 'countryCode', $filter])
                ;
            }
            $count = $query->count();
            $data['links']['pagination'] = [
                'total' => $count,
                'per_page' => $per_page,
                'current_page' => $page,
                'last_page' => ceil($count / $per_page),
                'next_page_url' => null,
                'prev_page_url' => null,
                'from' => $offset + 1,
                'to' => $offset + ($count > $per_page ? $per_page : $count),
            ];
        }

        return $this->asJson($data);
    }

    /**
     * Handle requests for the pages index table
     *
     * @param string $sort
     * @param int    $page
     * @param int    $per_page
     * @param string $filter
     * @param string $start
     * @param string $end
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionErrorsIndex(
        string $start = '',
        string $end = '',
        string $sort = 'url|DESC',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:errors');
        $data = [];
        $sortField = 'url';
        $sortType = 'DESC';
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        // Figure out the sorting type
        if ($sort !== '') {
            if (strpos($sort, '|') === false) {
                $sortField = $sort;
            } else {
                list($sortField, $sortType) = explode('|', $sort);
            }
        }
        $db = Craft::$app->getDb();
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->select([
                '[[url]]',
                'MIN([[title]]) as [[title]]',
                'MAX([[dateCreated]]) as [[latestErrorDate]]',
                'COUNT([[url]]) AS cnt',
            ])
            ->from(['{{%webperf_error_samples}}'])
            ->offset($offset)
            ->where(['between', 'dateCreated', $start, $end])
        ;
        if ($db->getIsMysql()) {
            $query
                ->addSelect([
                    'SUM([[type]] = \'craft\') as [[craftCount]]',
                    'SUM([[type]] = \'boomerang\') as [[boomerangCount]]',
                ]);
        }
        if ($db->getIsPgsql()) {
            $query
                ->addSelect([
                    'SUM(case when [[type]] = \'craft\' then 1 else 0 end) as [[craftCount]]',
                    'SUM(case when [[type]] = \'boomerang\' then 1 else 0 end) as [[boomerangCount]]',
                ]);
        }
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query
                ->andWhere(['like', 'url', $filter])
                ->orWhere(['like', 'title', $filter])
                ->orWhere(['like', 'pageErrors', $filter])
            ;
        }
        $query
            ->orderBy("[[{$sortField}]] {$sortType}")
            ->groupBy('url')
            ->limit($per_page)
        ;

        $stats = $query->all();
        if ($stats) {
            $user = Craft::$app->getUser()->getIdentity();
            // Massage the stats
            foreach ($stats as &$stat) {
                $stat['cnt'] = (int)$stat['cnt'];
                $stat['craftCount'] = (int)$stat['craftCount'];
                $stat['boomerangCount'] = (int)$stat['boomerangCount'];
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
                // Set up the appropriate helper links
                $stat['deleteLink'] = UrlHelper::actionUrl('webperf/error-samples/delete-samples-by-url', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId
                ]);
                $stat['detailPageUrl'] = UrlHelper::cpUrl('webperf/errors/page-detail', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId,
                ]);
                // Override based on permissions
                if (!$user->can('webperf:delete-error-samples')) {
                    $stat['deleteLink'] = '';
                }
                if (!$user->can('webperf:errors-detail')) {
                    $stat['detailPageUrl'] = '';
                }
            }
            // Format the data for the API
            $data['data'] = $stats;
            $query = (new Query())
                ->select(['[[url]]'])
                ->from(['{{%webperf_error_samples}}'])
                ->groupBy('[[url]]')
                ->where(['between', 'dateCreated', $start, $end])
            ;
            if ($filter !== '') {
                $query
                    ->andWhere(['like', 'url', $filter])
                    ->orWhere(['like', 'title', $filter])
                    ->orWhere(['like', 'pageErrors', $filter])
                ;
            }
            $count = $query->count();
            $data['links']['pagination'] = [
                'total' => $count,
                'per_page' => $per_page,
                'current_page' => $page,
                'last_page' => ceil($count / $per_page),
                'next_page_url' => null,
                'prev_page_url' => null,
                'from' => $offset + 1,
                'to' => $offset + ($count > $per_page ? $per_page : $count),
            ];
        }

        return $this->asJson($data);
    }


    /**
     * Handle requests for the performance detail table
     *
     * @param string $sort
     * @param int    $page
     * @param int    $per_page
     * @param string $filter
     * @param string $pageUrl
     * @param string $start
     * @param string $end
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionErrorsDetail(
        string $start = '',
        string $end = '',
        string $sort = 'dateCreated|DESC',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $pageUrl = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:errors');
        $data = [];
        $sortField = 'dateCreated';
        $sortType = 'DESC';
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        $pageUrl = urldecode($pageUrl);
        // Figure out the sorting type
        if ($sort !== '') {
            if (strpos($sort, '|') === false) {
                $sortField = $sort;
            } else {
                list($sortField, $sortType) = explode('|', $sort);
            }
        }
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->from(['{{%webperf_error_samples}} webperf_error_samples'])
            ->select([
                '[[webperf_error_samples.url]]',
                '[[webperf_error_samples.id]]',
                '[[webperf_error_samples.type]]',
                '[[webperf_error_samples.dateCreated]]',
                '[[webperf_error_samples.pageErrors]]',
                '[[webperf_error_samples.id]]',

                '[[webperf_data_samples.device]]',
                '[[webperf_data_samples.os]]',
                '[[webperf_data_samples.browser]]',
                '[[webperf_data_samples.countryCode]]',
                '[[webperf_data_samples.mobile]]',
            ])
            ->offset($offset)
            ->where(['[[webperf_error_samples.url]]' => $pageUrl])
            ->andWhere(['between', '[[webperf_error_samples.dateCreated]]', $start, $end])
            ->leftJoin('{{%webperf_data_samples}} webperf_data_samples', '[[webperf_data_samples.requestId]] = [[webperf_error_samples.requestId]]')
        ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query
                ->andWhere(['like', 'pageErrors', $filter])
                /*
                ->orWhere(['like', 'device', $filter])
                ->orWhere(['like', 'os', $filter])
                ->orWhere(['like', 'browser', $filter])
                ->orWhere(['like', 'countryCode', $filter])
                */
            ;
        }
        $query
            ->orderBy("{$sortField} {$sortType}")
            ->limit($per_page)
        ;
        $stats = $query->all();
        if ($stats) {
            $user = Craft::$app->getUser()->getIdentity();
            // Massage the stats
            foreach ($stats as &$stat) {
                if (!empty($stats['dateCreated'])) {
                    $date = DateTimeHelper::toDateTime($stats['dateCreated']);
                    $stats['dateCreated'] = $date->format('Y-m-d H:i:s');
                }
                if (isset($stat['mobile'])) {
                    $stat['mobile'] = (bool)$stat['mobile'];
                }
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
                $stat['deleteLink'] = UrlHelper::actionUrl('webperf/error-samples/delete-sample-by-id', [
                    'id' => $stat['id']
                ]);
                // Override based on permissions
                if (!$user->can('webperf:delete-error-samples')) {
                    $stat['deleteLink'] = '';
                }
            }
            // Format the data for the API
            $data['data'] = $stats;
            $query = (new Query())
                ->select(['[[url]]'])
                ->from(['{{%webperf_error_samples}}'])
                ->where(['url' => $pageUrl])
                ->andWhere(['between', 'dateCreated', $start, $end])
            ;
            if ($filter !== '') {
                $query
                    ->andWhere(['like', 'pageErrors', $filter])
                    /*
                    ->orWhere(['like', 'device', $filter])
                    ->orWhere(['like', 'os', $filter])
                    ->orWhere(['like', 'browser', $filter])
                    ->orWhere(['like', 'countryCode', $filter])
                    */
                ;
            }
            $count = $query->count();
            $data['links']['pagination'] = [
                'total' => $count,
                'per_page' => $per_page,
                'current_page' => $page,
                'last_page' => ceil($count / $per_page),
                'next_page_url' => null,
                'prev_page_url' => null,
                'from' => $offset + 1,
                'to' => $offset + ($count > $per_page ? $per_page : $count),
            ];
        }

        return $this->asJson($data);
    }

    // Protected Methods
    // =========================================================================
}
