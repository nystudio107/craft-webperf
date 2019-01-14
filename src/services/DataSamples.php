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
        // See if a redirect exists with this source URL already
        $testSample = (new Query())
            ->from(['{{%webperf_data_samples}}'])
            ->where(['requestId' => $dataSample->requestId])
            ->one();
        // If it exists, update it rather than having duplicates
        if (!empty($testSample)) {
            $isNew = false;
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
     * Trim samples that have the placeholder in the URL, aka they never
     * received the Boomerang beacon
     *
     * @param int $requestId
     */
    public function trimOrphanedSamples(int $requestId)
    {
        $db = Craft::$app->getDb();
        Craft::debug('Trimming orphaned samples', __METHOD__);
        // Update the existing record
        try {
            $db->createCommand()->delete(
                '{{%webperf_data_samples}}',
                [
                    'and', ['url' => DataSample::PLACEHOLDER_URL],
                    ['not', ['requestId' => $requestId]],
                ]
            )->execute();
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
