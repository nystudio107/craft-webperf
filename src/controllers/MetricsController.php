<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace {

    require_once __DIR__ . '/../lib/geoiploc.php';
}

namespace nystudio107\webperf\controllers {

    use Craft;
    use craft\errors\SiteNotFoundException;
    use craft\helpers\Json;
    use craft\helpers\UrlHelper;

    use craft\web\Controller;
    use Jaybizzle\CrawlerDetect\CrawlerDetect;

    use nystudio107\webperf\helpers\MultiSite;
    use nystudio107\webperf\models\BoomerangDbDataSample;
    use nystudio107\webperf\models\BoomerangDbErrorSample;
    use nystudio107\webperf\Webperf;
    use WhichBrowser\Parser;

    use yii\base\InvalidConfigException;

    /**
     * @author    nystudio107
     * @package   Webperf
     * @since     1.0.0
     */
    class MetricsController extends Controller
    {
        // Constants
        // =========================================================================

        const LAST_BEACON_CACHE_KEY = 'webperf-last-beacon';

        // Public Properties
        // =========================================================================

        public $enableCsrfValidation = false;

        // Protected Properties
        // =========================================================================

        /**
         * @var    bool|array Allows anonymous access to this controller's
         *         actions. The actions must be in 'kebab-case'
         * @access protected
         */
        protected $allowAnonymous = ['beacon'];


        // Public Methods
        // =========================================================================

        /**
         * @return void
         * @throws \yii\base\ExitException
         */
        public function actionBeacon()
        {
            // Rate limit the beacon sampling
            if ($this->rateLimited()) {
                Craft::$app->end();
            }
            // Get the incoming params from the beacon
            try {
                $params = Craft::$app->getRequest()->getBodyParams();
            } catch (InvalidConfigException $e) {
                $params = [];
            }
            // Ensure the beacon has at least the URL parameter
            if (empty($params) || empty($params['u'])) {
                Craft::$app->end();
            }
            // This parameter will exist (but have no value) if the beacon was
            // fired as part of the onbeforeunload event.
            if (isset($params['rt_quit'])) {
                Craft::$app->end();
            }
            // Filter out bot/spam requests via UserAgent
            if (Webperf::$settings->filterBotUserAgents) {
                $crawlerDetect = new CrawlerDetect();
                // Check the user agent of the current 'visitor'
                if ($crawlerDetect->isCrawler()) {
                    Craft::$app->end();
                }
            }
            // Allocate a new DataSample, and fill it in
            $sample = new BoomerangDbDataSample();
            $url = $params['u'];
            $sample->url = UrlHelper::stripQueryString($url);
            $sample->queryString = parse_url($url, PHP_URL_QUERY);
            // Get the site id
            try {
                $site = MultiSite::getSiteFromUrl($sample->url);
                $sample->siteId = $site->id;
            } catch (SiteNotFoundException $e) {
                $sample->siteId = null;
            }
            // Fill in all of the timing information that's available
            $sample->pageLoad = $params['t_done'] ?? null;
            if (!empty($params['nt_dns_end']) && !empty($params['nt_dns_st'])) {
                $sample->dns = $params['nt_dns_end'] - $params['nt_dns_st'];
                // If there was no delay, set it to null
                if ($sample->dns === 0) {
                    $sample->dns = null;
                }
            }
            if (!empty($params['nt_con_end']) && !empty($params['nt_con_st'])) {
                $sample->connect = $params['nt_con_end'] - $params['nt_con_st'];
                // If there was no delay, set it to null
                if ($sample->connect === 0) {
                    $sample->connect = null;
                }
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
            // Set the document title
            if (!empty($params['doc_title'])) {
                $sample->title = $params['doc_title'];
            }
            // Set the request id
            $sample->requestId = Webperf::$requestUuid;
            if (!empty($params['request_id'])) {
                $sample->requestId = $params['request_id'];
            }
            // Fill in information from the current request
            $request = Craft::$app->getRequest();
            $sample->countryCode = '??';
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
                $sample->device = ($parser->device->model ?? '');
                $sample->browser = ($parser->browser->name ?? '') . ' ' . $parser->browser->getVersion();
                $sample->os = ($parser->os->name ?? '') . ' ' . $parser->os->getVersion();
                $sample->mobile = $parser->isMobile();
            }
            // Save the data sample
            Craft::debug('Saving BoomerangDbDataSample: ' . print_r($sample->getAttributes(), true), __METHOD__);
            Webperf::$plugin->dataSamples->addDataSample($sample);
            if (!empty($params['err'])) {
                // Allocate a new ErrorSample, and fill it in
                $errorSample = new BoomerangDbErrorSample([
                    'requestId' => $sample->requestId,
                    'siteId' => $sample->siteId,
                    'url' => $sample->url,
                    'title' => $sample->title,
                    'pageErrors' => Json::decodeIfJson($params['err']),
                ]);
                // Save the error sample
                Craft::debug('Saving Boomerang ErrorSample: ' . print_r($errorSample->getAttributes(), true), __METHOD__);
                Webperf::$plugin->errorSamples->addErrorSample($errorSample);
            }
            Craft::$app->end();
        }

        // Protected Methods
        // =========================================================================

        /**
         * Don't allow a DDOS attack on the beacon endpoint by rate limiting the
         * data sample recording
         *
         * @return bool
         */
        protected function rateLimited(): bool
        {
            $limited = false;
            $now = round(microtime(true) * 1000);
            $cache = Craft::$app->getCache();
            $then = $cache->get(self::LAST_BEACON_CACHE_KEY);
            if (($then !== false) && ($now - (int)$then < Webperf::$settings->rateLimitMs)) {
                $limited = true;
            }
            $cache->set(self::LAST_BEACON_CACHE_KEY, $now, 0);

            return $limited;
        }
    }
}
