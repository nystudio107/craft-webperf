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

use nystudio107\webperf\validators\DbStringValidator;

use yii\behaviors\AttributeTypecastBehavior;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DataSample extends DbModel
{
    // Public Properties
    // =========================================================================

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
     * @var int (nt_dns_end - nt_dns_st) in ms
     */
    public $dns;

    /**
     * @var int (nt_con_end - nt_con_st) in ms
     */
    public $connect;

    /**
     * @var int t_resp in ms
     */
    public $firstByte;

    /**
     * @var int pt_fp in ms
     */
    public $firstPaint;

    /**
     * @var int pt_fcp in ms
     */
    public $firstContentfulPaint;

    /**
     * @var int (nt_domint - nt_nav_st) in ms
     */
    public $domInteractive;

    /**
     * @var int (nt_domcomp - nt_nav_st) or t_done in ms
     */
    public $pageLoad;

    /**
     * @var string the country code from the IP address
     */
    public $countryCode;

    /**
     * @var string the device name
     */
    public $device;

    /**
     * @var string the browser name
     */
    public $browser;

    /**
     * @var string the operating system
     */
    public $os;

    /**
     * @var bool mobile or non-mobile
     */
    public $mobile;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['siteId', 'integer'],
            ['url', 'required'],
            ['title', DbStringValidator::class, 'max' => 120],
            ['url', DbStringValidator::class, 'max' => 255],
            ['countryCode', DbStringValidator::class, 'max' => 2],
            ['device', DbStringValidator::class, 'max' => 50],
            ['browser', DbStringValidator::class, 'max' => 50],
            ['os', DbStringValidator::class, 'max' => 50],
            [
                [
                    'title',
                    'url',
                    'countryCode',
                    'device',
                    'browser',
                    'os',
                ],
                'string'
            ],
            [
                [
                    'dns',
                    'connect',
                    'firstByte',
                    'firstPaint',
                    'firstContentfulPaint',
                    'domInteractive',
                    'pageLoad',
                ],
                'integer'
            ],
            ['mobile', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                // 'attributeTypes' will be composed automatically according to `rules()`
            ],
        ];
    }
}
