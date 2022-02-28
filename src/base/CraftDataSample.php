<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\base;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
abstract class CraftDataSample extends FluentModel
{
    // Traits
    // =========================================================================

    use CraftDataSampleTrait {
        rules as craftRules;
    }

    // Constants
    // =========================================================================

    public const PLACEHOLDER_URL = 'webperf-craft-placeholder';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            $this->craftRules(),
            [
            ]
        );
    }
}
