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
trait BoomerangDataSampleTrait
{
    // Public Properties
    // =========================================================================

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
    public function rules(): array
    {
        return [
            [
                [
                    'countryCode',
                    'device',
                    'browser',
                    'os',
                ],
                'string',
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
                'integer',
            ],
            ['mobile', 'boolean'],
        ];
    }
}
