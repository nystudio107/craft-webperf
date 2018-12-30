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

use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class PerformanceSample extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The URL of the User Timing sample
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
    public $firstContenfulPaint;

    /**
     * @var int (nt_domint - nt_nav_st) in ms
     */
    public $domInteractive;

    /**
     * @var int (nt_domcomp - nt_nav_st) or t_done in ms
     */
    public $pageLoad;


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['url', 'string'],
            [
                [
                    'dns',
                    'connect',
                    'firstByte',
                    'firstPaint',
                    'firstContenfulPaint',
                    'domInteractive',
                    'pageLoad',
                ],
                'integer'
            ],
        ];
    }
}
