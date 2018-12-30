<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace {

    require_once '../lib/geoiploc.php';
}

namespace nystudio107\webperf\controllers {

    use Craft;
    use craft\web\Controller;
    use yii\base\InvalidConfigException;

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
            $request = Craft::$app->getRequest();
            $request->userAgent;
            getCountryFromIP($request->userIP);
            try {
                $params = Craft::$app->getRequest()->getBodyParams();
            } catch (InvalidConfigException $e) {
                $params = [];
            }
            if (empty($params)) {
                return;
            }
            $config = [

            ];
            Craft::debug(print_r($config, true), __METHOD__);
        }
    }
}
