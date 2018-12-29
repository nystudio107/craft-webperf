<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\controllers;

use nystudio107\webperf\Webperf;

use Craft;
use craft\web\Controller;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class MetricsController extends Controller
{

    // Public Properties
    // =========================================================================

    public $enableCsrfValidation = false;

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['beacon'];


    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionBeacon()
    {
        $data = Craft::$app->getRequest()->getBodyParams();
        Craft::debug(print_r($data, true), __METHOD__);
    }
}
