<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\services;

use craft\db\Query;
use nystudio107\webperf\Webperf;
use nystudio107\webperf\models\DataSample;

use Craft;
use craft\base\Component;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DataSamples extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param int    $siteId
     * @param string $column
     *
     * @return int|string
     */
    public function totalSamples(int $siteId, string $column)
    {
        // See if a redirect exists with this source URL already
        $query = (new Query())
            ->from(['{{%webperf_data_samples}}'])
            ->where(['not', [$column => null]])
            ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        return $query->count();
    }

    /**
     * Add a data sample to the webperf_data_samples table
     *
     * @param DataSample $dataSample
     */
    public function addDataSample(DataSample $dataSample)
    {
        // Validate the model before saving it to the db
        if ($dataSample->validate() === false) {
            Craft::error(
                Craft::t(
                    'webperf',
                    'Error validating data sample: {errors}',
                    ['errors' => print_r($dataSample->getErrors(), true)]
                ),
                __METHOD__
            );

            return;
        }
        $isNew = true;
        if (!empty($dataSample->requestId)) {
            // See if a redirect exists with this source URL already
            $testSample = (new Query())
                ->from(['{{%webperf_data_samples}}'])
                ->where(['requestId' => $dataSample->requestId])
                ->one();
            // If it exists, update it rather than having duplicates
            if (!empty($testSample)) {
                $isNew = false;
            }
        }
        // Get the validated model attributes and save them to the db
        $dataSampleConfig = $dataSample->getAttributes($dataSample->fields());
        $db = Craft::$app->getDb();
        if ($isNew) {
            Craft::debug('Creating new data sample', __METHOD__);
            // Create a new record
            try {
                $db->createCommand()->insert(
                    '{{%webperf_data_samples}}',
                    $dataSampleConfig
                )->execute();
            } catch (\Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
        } else {
            Craft::debug('Updating existing data sample', __METHOD__);
            // Update the existing record
            try {
                $db->createCommand()->update(
                    '{{%webperf_data_samples}}',
                    $dataSampleConfig,
                    [
                        'requestId' => $dataSample->requestId,
                    ]
                )->execute();
            } catch (\Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
        }
        // Trim orphaned samples
        $this->trimOrphanedSamples($dataSample->requestId);
        // After adding the DataSample, trim the webperf_data_samples db table
        if (Webperf::$settings->automaticallyTrimDataSamples) {
            $this->trimDataSamples();
        }
    }

    /**
     * Delete a data sample by id
     *
     * @param int $id
     *
     * @return int The result
     */
    public function deleteSampleById(int $id): int
    {
        $db = Craft::$app->getDb();
        // Delete a row from the db table
        try {
            $result = $db->createCommand()->delete(
                '{{%webperf_data_samples}}',
                [
                    'id' => $id,
                ]
            )->execute();
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
            $result = 0;
        }

        return $result;
    }

    /**
     * Delete data samples by URL and optionally siteId
     *
     * @param string   $url
     * @param int|null $siteId
     *
     * @return int
     */
    public function deleteDataSamplesByUrl(string $url, int $siteId = null): int
    {
        $db = Craft::$app->getDb();
        // Delete a row from the db table
        try {
            $conditions = ['url' => $url];
            if ($siteId !== null) {
                $conditions['siteId'] = $siteId;
            }
            $result = $db->createCommand()->delete(
                '{{%webperf_data_samples}}',
                $conditions
            )->execute();
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
            $result = 0;
        }

        return $result;
    }

    /**
     * Delete data all samples optionally siteId
     *
     * @param int|null $siteId
     *
     * @return int
     */
    public function deleteAllDataSamples(int $siteId = null): int
    {
        $db = Craft::$app->getDb();
        // Delete a row from the db table
        try {
            $conditions = [];
            if ($siteId !== null) {
                $conditions['siteId'] = $siteId;
            }
            $result = $db->createCommand()->delete(
                '{{%webperf_data_samples}}',
                $conditions
            )->execute();
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
            $result = 0;
        }

        return $result;
    }

    /**
     * Trim samples that have the placeholder in the URL, aka they never
     * received the Boomerang beacon
     *
     * @param int $requestId
     */
    public function trimOrphanedSamples($requestId)
    {
        $db = Craft::$app->getDb();
        Craft::debug('Trimming orphaned samples', __METHOD__);
        // Update the existing record
        try {
            $result = $db->createCommand()->delete(
                '{{%webperf_data_samples}}',
                [
                    'and', ['url' => DataSample::PLACEHOLDER_URL],
                    ['not', ['requestId' => $requestId]],
                ]
            )->execute();
            Craft::debug($result, __METHOD__);
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
    }

    /**
     * Trim the webperf_data_samples db table based on the dataSamplesStoredLimit
     * config.php setting
     *
     * @param int|null $limit
     *
     * @return int
     */
    public function trimDataSamples(int $limit = null): int
    {
        $affectedRows = 0;
        $db = Craft::$app->getDb();
        $quotedTable = $db->quoteTableName('{{%webperf_data_samples}}');
        $limit = $limit ?? Webperf::$settings->dataSamplesStoredLimit;

        if ($limit !== null) {
            //  https://stackoverflow.com/questions/578867/sql-query-delete-all-records-from-the-table-except-latest-n
            try {
                if ($db->getIsMysql()) {
                    // Handle MySQL
                    $affectedRows = $db->createCommand(/** @lang mysql */
                        "
                        DELETE FROM {$quotedTable}
                        WHERE id NOT IN (
                          SELECT id
                          FROM (
                            SELECT id
                            FROM {$quotedTable}
                            ORDER BY dateUpdated DESC
                            LIMIT {$limit}
                          ) foo
                        )
                        "
                    )->execute();
                }
                if ($db->getIsPgsql()) {
                    // Handle Postgres
                    $affectedRows = $db->createCommand(/** @lang mysql */
                        "
                        DELETE FROM {$quotedTable}
                        WHERE id NOT IN (
                          SELECT id
                          FROM (
                            SELECT id
                            FROM {$quotedTable}
                            ORDER BY \"dateUpdated\" DESC
                            LIMIT {$limit}
                          ) foo
                        )
                        "
                    )->execute();
                }
            } catch (\Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
            Craft::info(
                Craft::t(
                    'webperf',
                    'Trimmed {rows} from webperf_data_samples table',
                    ['rows' => $affectedRows]
                ),
                __METHOD__
            );
        }

        return $affectedRows;
    }
}
