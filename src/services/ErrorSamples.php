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
use nystudio107\webperf\base\DbErrorSampleInterface;
use nystudio107\webperf\events\ErrorSampleEvent;

use Craft;
use craft\base\Component;
use craft\db\Query;
use craft\helpers\Json;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class ErrorSamples extends Component
{
    // Constants
    // =========================================================================

    /**
     * @event ErrorSampleEvent The event that is triggered before the error sample is saved
     * You may set [[ErrorSampleEvent::isValid]] to `false` to prevent the error sample from getting saved.
     *
     * ```php
     * use nystudio107\webperf\services\ErrorSamples;
     * use nystudio107\retour\events\ErrorSampleEvent;
     *
     * Event::on(ErrorSamples::class,
     *     ErrorSamples::EVENT_BEFORE_SAVE_ERROR_SAMPLE,
     *     function(ErrorSampleEvent $event) {
     *         // potentially set $event->isValid;
     *     }
     * );
     * ```
     */
    const EVENT_BEFORE_SAVE_ERROR_SAMPLE = 'beforeSaveErrorSample';

    /**
     * @event ErrorSampleEvent The event that is triggered after the redirect is saved
     *
     * ```php
     * use nystudio107\webperf\services\ErrorSamples;
     * use nystudio107\webperf\events\ErrorSampleEvent;
     *
     * Event::on(ErrorSamples::class,
     *     ErrorSamples::EVENT_AFTER_SAVE_ERROR_SAMPLE,
     *     function(ErrorSampleEvent $event) {
     *         // the error sample was saved
     *     }
     * );
     * ```
     */
    const EVENT_AFTER_SAVE_ERROR_SAMPLE = 'afterSaveErrorSample';

    // Public Methods
    // =========================================================================

    /**
     * Get the total number of errors optionally limited by siteId
     *
     * @param int    $siteId
     * @param string $column
     *
     * @return int|string
     */
    public function totalErrorSamples(int $siteId, string $column)
    {
        // Get the total number of errors
        $query = (new Query())
            ->from(['{{%webperf_error_samples}}'])
            ->where(['not', [$column => null]])
            ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }

        return $query->count();
    }

    /**
     * Get the total number of errors optionally limited by siteId, between
     * $start and $end
     *
     * @param int    $siteId
     * @param string $start
     * @param string $end
     *
     * @return int|string
     */
    public function totalErrorSamplesRange(int $siteId, string $start, string $end)
    {
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end.'+1 day'));
        // Get the total number of errors
        $query = (new Query())
            ->from(['{{%webperf_error_samples}}'])
            ->where(['between', 'dateCreated', $start, $end])
        ;
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }

        return $query->count();
    }

    /**
     * Get the page title from errors by URL and optionally siteId
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
            ->from(['{{%webperf_error_samples}}'])
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
     * Add an error to the webperf_error_samples table
     *
     * @param DbErrorSampleInterface $errorSample
     */
    public function addErrorSample(DbErrorSampleInterface $errorSample)
    {
        // Validate the model before saving it to the db
        if ($errorSample->validate() === false) {
            Craft::error(
                Craft::t(
                    'webperf',
                    'Error validating error sample: {errors}',
                    ['errors' => print_r($errorSample->getErrors(), true)]
                ),
                __METHOD__
            );

            return;
        }
        // Trigger a 'beforeSaveErrorSample' event
        $event = new ErrorSampleEvent([
            'errorSample' => $errorSample,
        ]);
        $this->trigger(self::EVENT_BEFORE_SAVE_ERROR_SAMPLE, $event);
        if (!$event->isValid) {
            return;
        }
        // Get the validated model attributes and save them to the db
        $errorSampleConfig = $errorSample->getAttributes();
        if (!empty($errorSampleConfig['pageErrors'])) {
            if (\is_array($errorSampleConfig['pageErrors'])) {
                $errorSampleConfig['pageErrors'] = Json::encode($errorSampleConfig['pageErrors']);
            }
            $db = Craft::$app->getDb();
            Craft::debug('Creating new error sample', __METHOD__);
            // Create a new record
            try {
                $result = $db->createCommand()->insert(
                    '{{%webperf_error_samples}}',
                    $errorSampleConfig
                )->execute();
                Craft::debug($result, __METHOD__);
            } catch (\Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
            // Trigger a 'afterSaveErrorSample' event
            $this->trigger(self::EVENT_AFTER_SAVE_ERROR_SAMPLE, $event);
            // After adding the ErrorSample, trim the webperf_error_samples db table
            if (Webperf::$settings->automaticallyTrimErrorSamples) {
                $this->trimErrorSamples();
            }
        }
    }

    /**
     * Delete a error sample by id
     *
     * @param int $id
     *
     * @return int The result
     */
    public function deleteErrorSampleById(int $id): int
    {
        $db = Craft::$app->getDb();
        // Delete a row from the db table
        try {
            $result = $db->createCommand()->delete(
                '{{%webperf_error_samples}}',
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
     * Delete error samples by URL and optionally siteId
     *
     * @param string   $url
     * @param int|null $siteId
     *
     * @return int
     */
    public function deleteErrorSamplesByUrl(string $url, int $siteId = null): int
    {
        $db = Craft::$app->getDb();
        // Delete a row from the db table
        try {
            $conditions = ['url' => $url];
            if ($siteId !== null) {
                $conditions['siteId'] = $siteId;
            }
            $result = $db->createCommand()->delete(
                '{{%webperf_error_samples}}',
                $conditions
            )->execute();
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
            $result = 0;
        }

        return $result;
    }

    /**
     * Delete all error samples optionally siteId
     *
     * @param int|null $siteId
     *
     * @return int
     */
    public function deleteAllErrorSamples(int $siteId = null): int
    {
        $db = Craft::$app->getDb();
        // Delete a row from the db table
        try {
            $conditions = [];
            if ($siteId !== null) {
                $conditions['siteId'] = $siteId;
            }
            $result = $db->createCommand()->delete(
                '{{%webperf_error_samples}}',
                $conditions
            )->execute();
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
            $result = 0;
        }

        return $result;
    }

    /**
     * Trim the webperf_error_samples db table based on the errorSamplesStoredLimit
     * config.php setting
     *
     * @param int|null $limit
     *
     * @return int
     */
    public function trimErrorSamples(int $limit = null): int
    {
        $affectedRows = 0;
        $db = Craft::$app->getDb();
        $quotedTable = $db->quoteTableName('{{%webperf_error_samples}}');
        $limit = $limit ?? Webperf::$settings->errorSamplesStoredLimit;

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
                    'Trimmed {rows} from webperf_error_samples table',
                    ['rows' => $affectedRows]
                ),
                __METHOD__
            );
        }

        return $affectedRows;
    }
}
