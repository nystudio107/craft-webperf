<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\console\controllers;

use nystudio107\webperf\Webperf;

use Craft;
use yii\console\Controller;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class SamplesController extends Controller
{
    // Public Properties
    // =========================================================================

    /**
     * @var null|int
     */
    public $limit;

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array
     */
    protected $allowAnonymous = [
    ];

    // Public Methods
    // =========================================================================

    /**
     * @param string $actionID
     *
     * @return array|string[]
     */
    public function options($actionID): array
    {
        return [
            'limit',
        ];
    }

    /**
     * Trim the Webperf Data Samples and Error Samples database tables
     *
     * @return int
     */
    public function actionTrim(): int
    {
        echo Craft::t('webperf', 'Trimming data samples').PHP_EOL;
        $affectedRows = Webperf::$plugin->dataSamples->trimDataSamples($this->limit);
        echo Craft::t(
            'webperf',
            'Trimmed {rows} from webperf_data_samples table',
            ['rows' => $affectedRows]
        ).PHP_EOL;
        echo Craft::t('webperf', 'Trimming error samples').PHP_EOL;
        $affectedRows = Webperf::$plugin->errorSamples->trimErrorSamples($this->limit);
        echo Craft::t(
            'webperf',
            'Trimmed {rows} from webperf_error_samples table',
            ['rows' => $affectedRows]
        ).PHP_EOL;

        return 0;
    }
}
