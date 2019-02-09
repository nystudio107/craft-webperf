<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\services;

use nystudio107\webperf\Webperf;
use nystudio107\webperf\base\CraftDataSample;
use nystudio107\webperf\base\DbDataSampleInterface;
use nystudio107\webperf\events\DataSampleEvent;

use Craft;
use craft\base\Component;
use craft\db\Query;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DataSamples extends Component
{
    // Constants
    // =========================================================================

    const OUTLIER_PAGELOAD_MULTIPLIER = 10;

    /**
     * @event DataSampleEvent The event that is triggered before the data sample is saved
     * You may set [[DataSampleEvent::isValid]] to `false` to prevent the data sample from getting saved.
     *
     * ```php
     * use nystudio107\webperf\services\DataSamples;
     * use nystudio107\webperf\events\DataSampleEvent;
     *
     * Event::on(DataSamples::class,
     *     DataSamples::EVENT_BEFORE_SAVE_DATA_SAMPLE,
     *     function(DataSampleEvent $event) {
     *         // potentially set $event->isValid;
     *     }
     * );
     * ```
     */
    const EVENT_BEFORE_SAVE_DATA_SAMPLE = 'beforeSaveDataSample';

    /**
     * @event DataSampleEvent The event that is triggered after the redirect is saved
     *
     * ```php
     * use nystudio107\webperf\services\DataSamples;
     * use nystudio107\webperf\events\DataSampleEvent;
     *
     * Event::on(DataSamples::class,
     *     DataSamples::EVENT_AFTER_SAVE_DATA_SAMPLE,
     *     function(DataSampleEvent $event) {
     *         // the data sample was saved
     *     }
     * );
     * ```
     */
    const EVENT_AFTER_SAVE_DATA_SAMPLE = 'afterSaveDataSample';

    // Public Methods
    // =========================================================================

    /**
     * Get the total number of data samples optionally limited by siteId
     *
     * @param int    $siteId
     * @param string $column
     *
     * @return int|string
     */
    public function totalSamples(int $siteId, string $column)
    {
        // Get the total number of data samples
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
     * Get the page title from data samples by URL and optionally siteId
     *
     * @param string   $url
     * @param int $siteId
     *
     * @return string
     */
    public function pageTitle(string $url, int $siteId = 0): string
    {
        // Get the page title from a URL
        $query = (new Query())
            ->select(['title'])
            ->from(['{{%webperf_data_samples}}'])
            ->where([
                'and', ['url' => $url],
                ['not', ['title' => '']],
            ])
        ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        $result = $query->one();
        // Decode any emojis in the title
        if (!empty($result['title'])) {
            $result['title'] = html_entity_decode($result['title'], ENT_NOQUOTES, 'UTF-8');
        }

        return $result['title'] ?? '';
    }

    /**
     * Add a data sample to the webperf_data_samples table
     *
     * @param DbDataSampleInterface $dataSample
     */
    public function addDataSample(DbDataSampleInterface $dataSample)
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
            // See if a data sample exists with the same requestId already
            $testSample = (new Query())
                ->from(['{{%webperf_data_samples}}'])
                ->where(['requestId' => $dataSample->requestId])
                ->one();
            // If it exists, update it rather than having duplicates
            if (!empty($testSample)) {
                $isNew = false;
            }
        }
        // Trigger a 'beforeSaveDataSample' event
        $event = new DataSampleEvent([
            'isNew' => $isNew,
            'dataSample' => $dataSample,
        ]);
        $this->trigger(self::EVENT_BEFORE_SAVE_DATA_SAMPLE, $event);
        if (!$event->isValid) {
            return;
        }
        // Get the validated model attributes and save them to the db
        $dataSampleConfig = $dataSample->getAttributes();
        $db = Craft::$app->getDb();
        if ($isNew) {
            Craft::debug('Creating new data sample', __METHOD__);
            // Create a new record
            try {
                $result = $db->createCommand()->insert(
                    '{{%webperf_data_samples}}',
                    $dataSampleConfig
                )->execute();
                Craft::debug($result, __METHOD__);
            } catch (\Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
        } else {
            Craft::debug('Updating existing data sample', __METHOD__);
            // Update the existing record
            try {
                $result = $db->createCommand()->update(
                    '{{%webperf_data_samples}}',
                    $dataSampleConfig,
                    [
                        'requestId' => $dataSample->requestId,
                    ]
                )->execute();
                Craft::debug($result, __METHOD__);
            } catch (\Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
        }
        // Trigger a 'afterSaveDataSample' event
        $this->trigger(self::EVENT_AFTER_SAVE_DATA_SAMPLE, $event);
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
     * Trim any samples that our outliers
     */
    public function trimOutlierSamples()
    {
        if (Webperf::$settings->trimOutlierDataSamples) {
            $db = Craft::$app->getDb();
            Craft::debug('Trimming outlier samples', __METHOD__);
            // Get the average pageload time
            $stats = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->average('[[pageLoad]]');
            if (!empty($stats)) {
                $threshold = $stats * self::OUTLIER_PAGELOAD_MULTIPLIER;
                // Delete any samples that are far above average
                try {
                    $result = $db->createCommand()->delete(
                        '{{%webperf_data_samples}}',
                        ['>', '[[pageLoad]]', $threshold]
                    )->execute();
                    Craft::debug($result, __METHOD__);
                } catch (\Exception $e) {
                    Craft::error($e->getMessage(), __METHOD__);
                }
            }
        }
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
                    'and', ['url' => CraftDataSample::PLACEHOLDER_URL],
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
        $this->trimOutlierSamples();
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
                            ORDER BY dateCreated DESC
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
                            ORDER BY \"dateCreated\" DESC
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
