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

use Craft;

use craft\db\Query;
use craft\web\Controller;
use League\Csv\CannotInsertRecord;

use League\Csv\Writer;
use nystudio107\webperf\helpers\Permission as PermissionHelper;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class FileController extends Controller
{
    // Constants
    // =========================================================================

    public const EXPORT_DATA_SAMPLES_COLUMNS = [
        'siteId',
        'title',
        'url',
        'queryString',
        'dns',
        'connect',
        'firstByte',
        'firstPaint',
        'firstContentfulPaint',
        'domInteractive',
        'pageLoad',
        'countryCode',
        'device',
        'browser',
        'os',
        'mobile',
        'craftTotalMs',
        'craftDbMs',
        'craftDbCnt',
        'craftTwigMs',
        'craftTwigCnt',
        'craftOtherMs',
        'craftOtherCnt',
        'craftTotalMemory',
    ];

    public const EXPORT_ERROR_SAMPLES_COLUMNS = [
        'siteId',
        'title',
        'url',
        'queryString',
        'type',
        'pageErrors',
    ];

    // Protected Properties
    // =========================================================================

    protected array|bool|int $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * Export the data samples table as a CSV file
     *
     * @param string   $pageUrl
     * @param int|null $siteId
     *
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionExportDataSamples(string $pageUrl = '', int $siteId = null)
    {
        PermissionHelper::controllerPermissionCheck('webperf:performance');
        try {
            $this->exportCsvFile(
                'webperf-data-samples',
                '{{%webperf_data_samples}}',
                self::EXPORT_DATA_SAMPLES_COLUMNS,
                $pageUrl,
                $siteId
            );
        } catch (CannotInsertRecord $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
    }

    /**
     * Export the error samples table as a CSV file
     *
     * @param string   $pageUrl
     * @param int|null $siteId
     *
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionExportErrorSamples(string $pageUrl = '', int $siteId = null)
    {
        PermissionHelper::controllerPermissionCheck('webperf:errors');
        try {
            $this->exportCsvFile(
                'webperf-error-samples',
                '{{%webperf_error_samples}}',
                self::EXPORT_ERROR_SAMPLES_COLUMNS,
                $pageUrl,
                $siteId
            );
        } catch (CannotInsertRecord $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
    }

    // Public Methods
    // =========================================================================

    /**
     * @param string   $filename
     * @param string   $table
     * @param array    $columns
     * @param string   $pageUrl
     * @param int|null $siteId
     *
     * @throws \League\Csv\CannotInsertRecord
     */
    protected function exportCsvFile(
        string $filename,
        string $table,
        array $columns,
        string $pageUrl = '',
        int $siteId = null,
    ) {
        // If your CSV document was created or is read on a Macintosh computer,
        // add the following lines before using the library to help PHP detect line ending in Mac OS X
        if (!ini_get('auto_detect_line_endings')) {
            ini_set('auto_detect_line_endings', '1');
        }
        // Query the db table
        $query = (new Query())
            ->from([$table])
            ->select($columns)
            ;
        if (!empty($siteId)) {
            $query
                ->where(['siteId' => $siteId])
            ;
        }
        if (!empty($pageUrl)) {
            $query
                ->where(['pageUrl' => $pageUrl])
            ;
        }
        $data = $query
            ->all();
        // Create our CSV file writer
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne($columns);
        $csv->insertAll($data);
        $csv->output($filename . '.csv');
        exit(0);
    }
}
