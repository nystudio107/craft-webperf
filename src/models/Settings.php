<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\models;

use nystudio107\webperf\Webperf;

use Craft;
use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
