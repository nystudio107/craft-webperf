<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\records;

use craft\db\ActiveRecord;
use yii\behaviors\AttributeTypecastBehavior;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Alerts extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @var int
     */
    public int $siteId;

    // Public Properties
    // =========================================================================
    /**
     * @var string
     */
    public string $type;
    /**
     * @var string
     */
    public string $column;
    /**
     * @var int
     */
    public int $condition;
    /**
     * @var int
     */
    public int $interval;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%webperf_alerts}}';
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['siteId', 'integer'],
                ['type', 'string'],
                ['column', 'string'],
                ['condition', 'integer'],
                ['interval', 'integer'],
            ]
        );
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'typecast' => [
                    'class' => AttributeTypecastBehavior::class,
                    // 'attributeTypes' will be composed automatically according to `rules()`
                ],
            ]
        );
    }
}
