<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\models;

use nystudio107\webperf\base\BoomerangDataSample;
use nystudio107\webperf\base\DbDataSampleInterface;
use nystudio107\webperf\base\DbDataSampleTrait;
use nystudio107\webperf\validators\DbStringValidator;

use yii\behaviors\AttributeTypecastBehavior;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class BoomerangDbDataSample extends BoomerangDataSample implements DbDataSampleInterface
{
    // Traits
    // =========================================================================

    use DbDataSampleTrait {
        rules as dbRules;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            $this->dbRules(),
            [
                ['countryCode', DbStringValidator::class, 'max' => 2],
                ['device', DbStringValidator::class, 'max' => 50],
                ['browser', DbStringValidator::class, 'max' => 50],
                ['os', DbStringValidator::class, 'max' => 50],
            ]
        );
    }

    /**
     * @return array
     */
    public function behaviors()
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
