<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\log;

use nystudio107\webperf\Webperf;

use Craft;

use yii\log\Target;
use yii\log\Logger;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class ProfileTarget extends Target
{

    const PROFILE_CATEGORIES = [
        'database' => [
            'prefix' => 'yii\db',
        ],
        'twig' => [
            'prefix' => 'craft\web\twig\Template',
        ],
        'other' => [
            'prefix' => 'webperf-other',
        ],
    ];

    // Public Properties
    // =========================================================================

    public $stats = [];

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        foreach (self::PROFILE_CATEGORIES as $key => $value) {
            $this->stats[$key] = [
                'count' => 0,
                'duration' => 0.0,
                'memory' => 0,
            ];
        }
    }

    /**
     * Processes the given log messages.
     * This method will filter the given messages with [[levels]] and [[categories]].
     * And if requested, it will also export the filtering result to specific medium (e.g. email).
     * @param array $messages log messages to be processed. See [[Logger::messages]] for the structure
     * of each message.
     * @param bool $final whether this method is called at the end of the current application
     */
    public function collect($messages, $final)
    {
        // Merge in any messages intended for us
        $this->messages = array_merge(
            $this->messages,
            static::filterMessages($messages, $this->getLevels(), $this->categories, $this->except)
        );
        // Calculate the timings from the messages, and then reset them
        $timings = $this->calculateTimings($this->messages);
        $this->messages = [];
        // Loop through and tally up all of the timings
        foreach ($timings as $timing) {
            $cat = 'other';
            foreach (self::PROFILE_CATEGORIES as $key => $value) {
                if (strpos($timing['category'], $value['prefix']) === 0) {
                    $cat = $key;
                }
            }
            $this->stats[$cat]['count']++;
            $this->stats[$cat]['duration'] += (float)$timing['duration'] * 1000;
            $this->stats[$cat]['memory'] += (int)$timing['memoryDiff'];
        }
        if ($final) {
            $this->export();
            Webperf::$plugin->beacons->includeCraftBeacon();
        }
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
    }

    // Protected Methods
    // =========================================================================

    /**
     * Calculates the elapsed time for the given log messages.
     * @param array $messages the log messages obtained from profiling
     * @return array timings. Each element is an array consisting of these elements:
     * `info`, `category`, `timestamp`, `trace`, `level`, `duration`, `memory`, `memoryDiff`.
     * The `memory` and `memoryDiff` values are available since version 2.0.11.
     */
    protected function calculateTimings($messages): array
    {
        $timings = [];
        $stack = [];

        foreach ($messages as $i => $log) {
            list($token, $level, $category, $timestamp, $traces) = $log;
            $memory = isset($log[5]) ? $log[5] : 0;
            $log[6] = $i;
            $hash = md5(json_encode($token));
            if ($level == Logger::LEVEL_PROFILE_BEGIN) {
                $stack[$hash] = $log;
            } elseif ($level == Logger::LEVEL_PROFILE_END) {
                if (isset($stack[$hash])) {
                    $timings[$stack[$hash][6]] = [
                        'category' => $stack[$hash][2],
                        'timestamp' => $stack[$hash][3],
                        'level' => count($stack) - 1,
                        'duration' => $timestamp - $stack[$hash][3],
                        'memory' => $memory,
                        'memoryDiff' => $memory - (isset($stack[$hash][5]) ? $stack[$hash][5] : 0),
                    ];
                    unset($stack[$hash]);
                }
            }
        }

        return array_values($timings);
    }
}
