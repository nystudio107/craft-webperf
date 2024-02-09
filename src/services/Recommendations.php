<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\services;

use Craft;
use craft\base\Component;
use craft\db\Query;
use nystudio107\webperf\base\Recommendation;
use nystudio107\webperf\models\RecommendationDataSample;
use nystudio107\webperf\recommendations\CraftQueryCount;
use nystudio107\webperf\recommendations\CraftQueryTime;
use nystudio107\webperf\recommendations\CraftTotalTime;
use nystudio107\webperf\recommendations\CraftTwigTime;
use nystudio107\webperf\recommendations\DomInteractive;
use nystudio107\webperf\recommendations\FirstByte;
use nystudio107\webperf\recommendations\FirstContentfulPaint;
use nystudio107\webperf\recommendations\MemoryLimit;
use yii\helpers\Markdown;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Recommendations extends Component
{
    // Constants
    // =========================================================================

    protected const RECOMMENDATIONS_LIST = [
        CraftQueryCount::class,
        CraftQueryTime::class,
        CraftTwigTime::class,
        CraftTotalTime::class,
        FirstByte::class,
        FirstContentfulPaint::class,
        DomInteractive::class,
        MemoryLimit::class,
    ];

    // Public Methods
    // =========================================================================

    /**
     * Return a list of recommendations
     *
     * @param RecommendationDataSample $sample
     *
     * @return array
     */
    public function list(RecommendationDataSample $sample): array
    {
        $data = [];
        foreach (self::RECOMMENDATIONS_LIST as $recClass) {
            /** @var Recommendation $rec */
            $rec = new $recClass(['sample' => $sample]);
            if ($rec->hasRecommendation) {
                $data[] = [
                    'summary' => Markdown::processParagraph($rec->summary),
                    'detail' => Markdown::processParagraph($rec->detail),
                    'learnMoreUrl' => $rec->learnMoreUrl,
                ];
            }
        }
        return $data;
    }

    /**
     * Return a list of recommendations
     *
     * @param string $pageUrl
     * @param string $start
     * @param string $end
     * @param int $siteId
     *
     * @return array
     */
    public function data(
        $pageUrl = '',
        string $start = '',
        string $end = '',
        $siteId = 0,
    ): array {
        $data = [];
        $db = Craft::$app->getDb();
        // Add a day since YYYY-MM-DD is really YYYY-MM-DD 00:00:00
        $end = date('Y-m-d', strtotime($end . '+1 day'));
        $pageUrl = urldecode($pageUrl);
        // Query the db table
        $query = (new Query())
            ->select([
                'COUNT([[url]]) AS [[cnt]]',

                'AVG([[pageLoad]]) AS [[pageLoad]]',
                'AVG([[domInteractive]]) AS [[domInteractive]]',
                'AVG([[firstContentfulPaint]]) AS [[firstContentfulPaint]]',
                'AVG([[firstPaint]]) AS [[firstPaint]]',
                'AVG([[firstByte]]) AS [[firstByte]]',
                'AVG([[connect]]) AS [[connect]]',
                'AVG([[dns]]) AS [[dns]]',

                'AVG([[craftTotalMs]]) AS [[craftTotalMs]]',
                'AVG([[craftDbMs]]) AS [[craftDbMs]]',
                'AVG([[craftDbCnt]]) AS [[craftDbCnt]]',
                'AVG([[craftTwigMs]]) AS [[craftTwigMs]]',
                'AVG([[craftTwigCnt]]) AS [[craftTwigCnt]]',
                'AVG([[craftOtherMs]]) AS [[craftOtherMs]]',
                'AVG([[craftOtherCnt]]) AS [[craftOtherCnt]]',
                'AVG([[craftTotalMemory]]) AS [[craftTotalMemory]]',
            ])
            ->from(['{{%webperf_data_samples}}'])
            ->where(['between', 'dateCreated', $start, $end]);
        if (!empty($pageUrl)) {
            $query->andWhere(['url' => $pageUrl]);
        }
        if ((int)$siteId !== 0) {
            $query->andWhere(['siteId' => $siteId]);
        }
        $stats = $query->all();
        if ($stats) {
            $data = $stats[0];
        }

        return $data;
    }
}
