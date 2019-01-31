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
    // Public Properties
    // =========================================================================

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

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
     *
     * @throws \yii\base\ExitException
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
