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
trait CraftDataSampleTrait
{
    // Public Properties
    // =========================================================================

    /**
     * @var int (nt_domcomp - nt_nav_st) or t_done in ms
     */
    public $pageLoad;

    /**
     * @var int
     */
    public $craftTotalMs;

    /**
     * @var int
     */
    public $craftDbMs;

    /**
     * @var int
     */
    public $craftDbCnt;

    /**
     * @var int
     */
    public $craftTwigMs;

    /**
     * @var int
     */
    public $craftTwigCnt;

    /**
     * @var int
     */
    public $craftOtherMs;

    /**
     * @var int
     */
    public $craftOtherCnt;

    /**
     * @var int
     */
    public $craftTotalMemory;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'pageLoad',
                    'craftTotalMs',
                    'craftDbMs',
                    'craftDbCnt',
                    'craftTwigMs',
                    'craftTwigCnt',
                    'craftOtherMs',
                    'craftOtherCnt',
                    'craftTotalMemory',
                ],
                'integer'
            ],
        ];
    }
}
