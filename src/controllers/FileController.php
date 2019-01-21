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

use craft\db\Query;
use craft\web\Controller;

use League\Csv\Writer;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class FileController extends Controller
{
    // Constants
    // =========================================================================

    const EXPORT_DATA_SAMPLES_COLUMNS = [
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
    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * Export the statistics table as a CSV file
     *
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionExportDataSamples()
    {
        PermissionHelper::controllerPermissionCheck('webperf:pages');
        $this->exportCsvFile('webperf-data-samples', '{{%webperf_data_samples}}', self::EXPORT_DATA_SAMPLES_COLUMNS);
    }

    // Public Methods
    // =========================================================================

    /**
     * @param string   $filename
     * @param string   $table
     * @param array    $columns
     * @param int|null $siteId
     */
    protected function exportCsvFile(string $filename, string $table, array $columns, int $siteId = null)
    {
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
        if ($siteId !== null) {
            $query
                ->where(['siteId' => $siteId])
                ;
        }
        $data = $query
            ->all();
        // Create our CSV file writer
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne($columns);
        $csv->insertAll($data);
        $csv->output($filename.'.csv');
        exit(0);
    }
}
