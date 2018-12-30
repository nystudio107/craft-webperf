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

    require_once __DIR__ . '/../lib/geoiploc.php';
}

namespace nystudio107\webperf\controllers {

    use nystudio107\webperf\Webperf;
    use nystudio107\webperf\models\DataSample;

    use Craft;
    use craft\web\Controller;

    use yii\base\InvalidConfigException;

    use WhichBrowser\Parser;

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
            // Get the incoming params from the beacon
            try {
                $params = Craft::$app->getRequest()->getBodyParams();
            } catch (InvalidConfigException $e) {
                $params = [];
            }
            // Ensure the beacon has at least the URL parameter
            if (empty($params) || empty($params['u'])) {
                return;
            }
            // Allocate a new DataSample, and fill it in
            $sample = new DataSample();
            $sample->url = $params['u'] ?? null;
            // Fill in all of the timing information that's available
            $sample->pageLoad = $params['t_done'] ?? null;
            if (!empty($params['nt_dns_end']) && !empty($params['nt_dns_st'])) {
                $sample->dns = $params['nt_dns_end'] - $params['nt_dns_st'];
            }
            if (!empty($params['nt_con_end']) && !empty($params['nt_con_st'])) {
                $sample->connect = $params['nt_con_end'] - $params['nt_con_st'];
            }
            if (!empty($params['t_resp'])) {
                $sample->firstByte = $params['t_resp'];
            }
            if (!empty($params['pt_fp'])) {
                $sample->firstPaint = $params['pt_fp'];
            }
            if (!empty($params['pt_fcp'])) {
                $sample->firstContentfulPaint = $params['pt_fcp'];
            }
            if (!empty($params['nt_domint']) && !empty($params['nt_nav_st'])) {
                $sample->domInteractive = $params['nt_domint'] - $params['nt_nav_st'];
            }
            if (!empty($params['nt_domcomp']) && !empty($params['nt_nav_st'])) {
                $sample->pageLoad = $params['nt_domcomp'] - $params['nt_nav_st'];
            }
            // Fill in information from the current request
            $request = Craft::$app->getRequest();
            $ip = $request->userIP;
            if ($ip) {
                $sample->countryCode = getCountryFromIP($ip);
                // getCountryFromIP returns 'ZZ' for unknown countries, map to '??'
                if ($sample->countryCode === 'ZZ') {
                    $sample->countryCode = '??';
                }
            }
            $userAgent = $request->userAgent;
            if ($userAgent) {
                $parser = new Parser($userAgent);
                $sample->browser = $parser->browser->name;
                $sample->os = $parser->os->name;
                $sample->mobile = $parser->isMobile();
            }
            // Save the data sample
            Craft::debug('Saving DataSample: '.print_r($sample, true), __METHOD__);
            Webperf::$plugin->dataSamples->addDataSample($sample);
        }
    }
}
