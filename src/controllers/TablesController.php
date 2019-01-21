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
     * Handle requests for the dashboard statistics table
     *
     * @param string $sort
     * @param int    $page
     * @param int    $per_page
     * @param string $filter
     * @param null   $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionPagesIndex(
        string $sort = 'pageLoad|desc',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:pages');
        $data = [];
        $sortField = 'pageLoad';
        $sortType = 'DESC';
        // Figure out the sorting type
        if ($sort !== '') {
            if (strpos($sort, '|') === false) {
                $sortField = $sort;
            } else {
                list($sortField, $sortType) = explode('|', $sort);
            }
        }
        if ($sortField === 'totalPageLoad') {
            $sortField = 'pageLoad';
        }
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->select([
                'url',
                'MIN(title) AS title',
                'COUNT(url) AS cnt',
                'AVG(pageLoad) AS pageLoad',
                'AVG(domInteractive) AS domInteractive',
                'AVG(firstContentfulPaint) AS firstContentfulPaint',
                'AVG(firstPaint) AS firstPaint',
                'AVG(firstByte) AS firstByte',
                'AVG(connect) AS connect',
                'AVG(dns) AS dns',
                'AVG(craftTotalMs) AS craftTotalMs',
                'AVG(craftDbCnt) AS craftDbCnt',
                'AVG(craftDbMs) AS craftDbMs',
                'AVG(craftTwigCnt) AS craftTwigCnt',
                'AVG(craftTwigMs) AS craftTwigMs',
                'AVG(craftTotalMemory) AS craftTotalMemory',
            ])
            ->from(['{{%webperf_data_samples}}'])
            ->offset($offset)
            ;
        if ((int)$siteId !== 0) {
            $query->where(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query
                ->where(['like', 'url', $filter])
                ->orWhere(['like', 'title', $filter])
            ;
        }
        $query
            ->orderBy("{$sortField} {$sortType}")
            ->groupBy('url')
            ->limit($per_page)
        ;

        $stats = $query->all();
        if ($stats) {
            // Compute the largest page load time
            $maxTotalPageLoad = 0;
            foreach ($stats as &$stat) {
                // Determine the stat type
                if (!empty($stat['pageLoad']) && !empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'both';
                }
                if (empty($stat['pageLoad'])) {
                    $stat['type'] = 'craft';
                }
                if (empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'frontend';
                }
                if (empty($stat['pageLoad'])) {
                    $pageLoad = $stat['craftTotalMs'];
                } else {
                    $pageLoad = $stat['pageLoad'];
                }
                if ($pageLoad > $maxTotalPageLoad) {
                    $maxTotalPageLoad = $pageLoad;
                }
            }
            // Massage the stats
            $index = 1;
            foreach ($stats as &$stat) {
                $stat['id'] = $index++;
                $stat['maxTotalPageLoad'] = (int)$maxTotalPageLoad;
                // If there is no frontend beacon timing, use the Craft timing
                if (empty($stat['pageLoad'])) {
                    $stat['totalPageLoad'] = (int)$stat['craftTotalMs'];
                } else {
                    $stat['totalPageLoad'] = (int)$stat['pageLoad'];
                }
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
                // Set up the appropriate helper links
                $stat['deleteLink'] = UrlHelper::actionUrl('webperf/data-samples/delete-samples-by-url', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId
                ]);
                $stat['detailPageUrl'] = UrlHelper::cpUrl('webperf/page-detail', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId,
                ]);
                // Override based on permissions
                $user = Craft::$app->getUser()->getIdentity();
                if (!$user->can('webperf:delete-data-samples')) {
                    $stat['deleteLink'] = '';
                }
                if (!$user->can('webperf:page-detail')) {
                    $stat['detailPageUrl'] = '';
                }
            }
            // Format the data for the API
            $data['data'] = $stats;
            $query = (new Query())
                ->from(['{{%webperf_data_samples}}'])
                ->groupBy('url');
            if ($filter !== '') {
                $query->where(['like', 'url', $filter]);
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
     * Handle requests for the dashboard statistics table
     *
     * @param string $sort
     * @param int    $page
     * @param int    $per_page
     * @param string $filter
     * @param string $pageUrl
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionPageDetail(
        string $sort = 'pageLoad|desc',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $pageUrl = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:pages');
        $data = [];
        $sortField = 'pageLoad';
        $sortType = 'DESC';
        $pageUrl = urldecode($pageUrl);
        // Figure out the sorting type
        if ($sort !== '') {
            if (strpos($sort, '|') === false) {
                $sortField = $sort;
            } else {
                list($sortField, $sortType) = explode('|', $sort);
            }
        }
        if ($sortField === 'totalPageLoad') {
            $sortField = 'pageLoad';
        }
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->from(['{{%webperf_data_samples}}'])
            ->offset($offset)
            ->where(['url' => $pageUrl])
        ;
        if ((int)$siteId !== 0) {
            $query->where(['siteId' => $siteId]);
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
            // Compute the largest page load time
            $maxTotalPageLoad = 0;
            foreach ($stats as &$stat) {
                // Determine the stat type
                if (!empty($stat['pageLoad']) && !empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'both';
                }
                if (empty($stat['pageLoad'])) {
                    $stat['type'] = 'craft';
                }
                if (empty($stat['craftTotalMs'])) {
                    $stat['type'] = 'frontend';
                }
                if (empty($stat['pageLoad'])) {
                    $pageLoad = $stat['craftTotalMs'];
                } else {
                    $pageLoad = $stat['pageLoad'];
                }
                if ($pageLoad > $maxTotalPageLoad) {
                    $maxTotalPageLoad = $pageLoad;
                }
            }
            // Massage the stats
            foreach ($stats as &$stat) {
                $stat['maxTotalPageLoad'] = (int)$maxTotalPageLoad;
                // If there is no frontend beacon timing, use the Craft timing
                if (empty($stat['pageLoad'])) {
                    $stat['totalPageLoad'] = (int)$stat['craftTotalMs'];
                } else {
                    $stat['totalPageLoad'] = (int)$stat['pageLoad'];
                }
                // Decode any emojis in the title
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
                $stat['deleteLink'] = UrlHelper::actionUrl('webperf/data-samples/delete-sample-by-id', [
                    'id' => $stat['id']
                ]);
                // Override based on permissions
                $user = Craft::$app->getUser()->getIdentity();
                if (!$user->can('webperf:delete-data-samples')) {
                    $stat['deleteLink'] = '';
                }
            }
            // Format the data for the API
            $data['data'] = $stats;
            $query = (new Query())
                ->from(['{{%webperf_data_samples}}'])
                ->where(['url' => $pageUrl])
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

    // Protected Methods
    // =========================================================================
}
