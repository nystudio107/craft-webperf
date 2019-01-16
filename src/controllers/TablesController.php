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

use nystudio107\webperf\helpers\Permission as PermissionHelper;

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
        // Query the db table
        $offset = ($page - 1) * $per_page;
        $query = (new Query())
            ->select([
                'url',
                'MIN(title) AS title',
                'COUNT(url) AS cnt',
                'AVG(pageLoad) AS pageLoad',
                'AVG(craftDbCnt) AS craftDbCnt',
                'AVG(craftTwigCnt) AS craftTwigCnt',
                'AVG(craftOtherCnt) AS craftOtherCnt',
                'AVG(craftTotalMemory) AS craftTotalMemory',
            ])
            ->from(['{{%webperf_data_samples}}'])
            ->offset($offset);
        if ((int)$siteId !== 0) {
            $query->where(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query->where(['like', 'url', $filter]);
            $query->orWhere(['like', 'title', $filter]);
        }
        $query
            ->orderBy("{$sortField} {$sortType}")
            ->groupBy('url')
            ->limit($per_page);

        $stats = $query->all();
        if ($stats) {
            // Decode any emojis in the title
            $index = 1;
            foreach ($stats as &$stat) {
                $stat['id'] = $index++;
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
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
     * Handle requests for the dashboard redirects table
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
    public function actionRedirects(
        string $sort = 'hitCount|desc',
        int $page = 1,
        int $per_page = 20,
        $filter = '',
        $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:redirects');
        $data = [];
        $sortField = 'hitCount';
        $sortType = 'DESC';
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
            ->from(['{{%retour_static_redirects}}'])
            ->offset($offset)
            ->limit($per_page)
            ->orderBy("{$sortField} {$sortType}");
        if ((int)$siteId !== 0) {
            $query->where(['siteId' => $siteId]);
        }
        if ($filter !== '') {
            $query->where(['like', 'redirectSrcUrl', $filter]);
            $query->orWhere(['like', 'redirectDestUrl', $filter]);
        }
        $redirects = $query->all();
        // Add in the `deleteLink` field
        foreach ($redirects as &$redirect) {
            $redirect['deleteLink'] = UrlHelper::cpUrl('retour/delete-redirect/'.$redirect['id']);
            $redirect['editLink'] = UrlHelper::cpUrl('retour/edit-redirect/'.$redirect['id']);
        }
        // Format the data for the API
        if ($redirects) {
            $data['data'] = $redirects;
            $query = (new Query())
                ->from(['{{%retour_static_redirects}}']);
            if ($filter !== '') {
                $query->where(['like', 'redirectSrcUrl', $filter]);
                $query->orWhere(['like', 'redirectDestUrl', $filter]);
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
