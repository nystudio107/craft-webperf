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

use nystudio107\webperf\base\CraftDataSampleTrait;
use nystudio107\webperf\base\BoomerangDataSampleTrait;

use nystudio107\webperf\base\FluentModel;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class RecommendationDataSample extends FluentModel
{
    // Traits
    // =========================================================================

    use CraftDataSampleTrait {
        rules as craftRules;
    }

    use BoomerangDataSampleTrait {
        rules as boomerangRules;
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
            $this->craftRules(),
            $this->boomerangRules(),
            [
            ]
        );
    }
}
