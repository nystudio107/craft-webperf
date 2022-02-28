<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\events;

use yii\base\ModelEvent;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class AlertEvent extends ModelEvent
{
    // Properties
    // =========================================================================

    /**
     * @var bool Whether the redirect is brand new
     */
    public $isNew = false;

    /**
     * @var string The old URL
     */
    public $legacyUrl;

    /**
     * @var string The new URL
     */
    public $destinationUrl;

    /**
     * @var string The type of matching done on the legacyUrl
     */
    public $matchType;

    /**
     * @var string The type of redirect
     */
    public $redirectType;
}
