<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\validators;

use craft\helpers\StringHelper;
use nystudio107\webperf\helpers\Text as TextHelper;
use yii\base\InvalidConfigException;
use yii\validators\Validator;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DbStringValidator extends Validator
{
    /**
     * @var null|int
     */
    public $max = null;


    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        if ($this->max === null) {
            throw new InvalidConfigException('The "max" property must be set.');
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute): void
    {
        $value = $model->$attribute;
        $value = TextHelper::cleanupText($value);
        $value = StringHelper::encodeMb4($value);
        $value = TextHelper::truncate($value, $this->max);
        $model->$attribute = $value;
    }
}
