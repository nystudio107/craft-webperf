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

use nystudio107\webperf\validators\DbStringValidator;

use craft\validators\ArrayValidator;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
trait DbErrorSampleTrait
{
    // Properties
    // =========================================================================

    /**
     * @var int
     */
    public $requestId;

    /**
     * @var int
     */
    public $siteId;

    /**
     * @var string the title of the document (if any)
     */
    public $title;

    /**
     * @var string u - the URL of the User Timing sample
     */
    public $url;

    /**
     * @var string the type of the errors (`javascript` or `craft`)
     */
    public $type;

    /**
     * @var array array of the errors
     */
    public $pageErrors;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['requestId', 'integer'],
            ['siteId', 'integer'],
            ['title', DbStringValidator::class, 'max' => 120],
            ['url', DbStringValidator::class, 'max' => 255],
            ['type', DbStringValidator::class, 'max' => 16],
            ['pageErrors', ArrayValidator::class],
            [
                [
                    'title',
                    'type',
                    'url',
                ],
                'string'
            ],
        ];
    }
}
