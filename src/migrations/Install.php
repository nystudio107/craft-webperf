<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\migrations;

use nystudio107\webperf\Webperf;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%webperf_data_samples}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%webperf_data_samples}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),

                    'requestId' => $this->bigInteger(),
                    'siteId' => $this->integer(),
                    'title' => $this->string(120),
                    'url' => $this->string(255)->notNull()->defaultValue(''),
                    'dns' => $this->integer(),
                    'connect' => $this->integer(),
                    'firstByte' => $this->integer(),
                    'firstPaint' => $this->integer(),
                    'firstContentfulPaint' => $this->integer(),
                    'domInteractive' => $this->integer(),
                    'pageLoad' => $this->integer(),
                    'countryCode' => $this->string(2),
                    'device' => $this->string(50),
                    'browser' => $this->string(50),
                    'os' => $this->string(50),
                    'mobile' => $this->boolean(),
                    'craftTotalMs' => $this->integer(),
                    'craftDbMs' => $this->integer(),
                    'craftDbCnt' => $this->integer(),
                    'craftTwigMs' => $this->integer(),
                    'craftTwigCnt' => $this->integer(),
                    'craftOtherMs' => $this->integer(),
                    'craftOtherCnt' => $this->integer(),
                    'craftTotalMemory' => $this->integer(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(
            $this->db->getIndexName(
                '{{%webperf_data_samples}}',
                'url',
                false
            ),
            '{{%webperf_data_samples}}',
            'url',
            false
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%webperf_data_samples}}', 'siteId'),
            '{{%webperf_data_samples}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%webperf_data_samples}}');
    }
}
