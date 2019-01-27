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

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
trait DbDataSampleTrait
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
     * @var string the query string
     */
    public $queryString;

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
            ['queryString', DbStringValidator::class, 'max' => 255],
            ['title', 'string'],
            ['url', 'string'],
            ['queryString', 'string'],
        ];
    }
}
