<?php

namespace nystudio107\webperf\migrations;

use Craft;
use craft\db\Migration;

/**
 * m190625_151715_add_indexes migration.
 */
class m190625_151715_add_indexes extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Add webperf_data_samples indexes
        $this->createIndex(
            $this->db->getIndexName(
                '{{%webperf_data_samples}}',
                'dateCreated',
                false
            ),
            '{{%webperf_data_samples}}',
            'dateCreated',
            false
        );
        $this->createIndex(
            $this->db->getIndexName(
                '{{%webperf_data_samples}}',
                'requestId',
                false
            ),
            '{{%webperf_data_samples}}',
            'requestId',
            false
        );
        // Add webperf_error_samples indexes
        $this->createIndex(
            $this->db->getIndexName(
                '{{%webperf_error_samples}}',
                'dateCreated',
                false
            ),
            '{{%webperf_error_samples}}',
            'dateCreated',
            false
        );
        $this->createIndex(
            $this->db->getIndexName(
                '{{%webperf_error_samples}}',
                'requestId',
                false
            ),
            '{{%webperf_error_samples}}',
            'requestId',
            false
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190625_151715_add_indexes cannot be reverted.\n";
        return false;
    }
}
