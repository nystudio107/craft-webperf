<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\log;

use nystudio107\webperf\Webperf;

use yii\log\Target;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class ErrorsTarget extends Target
{
    // Constants
    // =========================================================================

    const ERROR_LEVELS = [
        1 => 'error',
        2 => 'warning',
    ];

    // Public Properties
    // =========================================================================

    /**
     * @var array accumulated page errors
     */
    public $pageErrors = [];

    // Public Methods
    // =========================================================================

    /**
     * Processes the given log messages.
     * This method will filter the given messages with [[levels]] and
     * [[categories]]. And if requested, it will also export the filtering
     * result to specific medium (e.g. email).
     *
     * @param array $messages log messages to be processed. See
     *                        [[Logger::messages]] for the structure of each
     *                        message.
     * @param bool  $final    whether this method is called at the end of the
     *                        current application
     */
    public function collect($messages, $final)
    {
        // Bail if either values are null
        if (($messages === null) || ($this->messages === null)) {
            return;
        }
        // Merge in any messages intended for us
        $this->messages = array_merge(
            $this->messages,
            static::filterMessages($messages, $this->getLevels(), $this->categories, $this->except)
        );
        foreach ($this->messages as $message) {
            // Ignore objects/arrays
            if (!\is_string($message[0])) {
                continue;
            }
            $this->pageErrors[] = [
                'level' => self::ERROR_LEVELS[$message[1]],
                'message' => $message[0],
                'category' => $message[2],
            ];
        }
        $this->messages = [];
        if ($final) {
            $this->export();
            Webperf::$plugin->beacons->includeCraftErrorsBeacon();
        }
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
    }
}
