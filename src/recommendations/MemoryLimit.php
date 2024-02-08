<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\recommendations;

use Craft;
use nystudio107\webperf\base\Recommendation;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class MemoryLimit extends Recommendation
{
    // Constants
    // =========================================================================

    protected const MIN_CRAFT_MEMORY = 64 * 1024 * 1024;
    protected const MAX_CRAFT_MEMORY = 1024 * 1024 * 1024;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function evaluate(): void
    {
        $phpMemoryLimit = (int)$this->memoryLimit();
        $this->sample->craftTotalMemory = (int)$this->sample->craftTotalMemory;
        if ($phpMemoryLimit && $this->sample->craftTotalMemory) {
            $ratio = $phpMemoryLimit / $this->sample->craftTotalMemory;
            $displayCraftTotalMemory = (($this->sample->craftTotalMemory / 1024) / 1024) . 'M';
            $displayPhpMemoryLimit = (($phpMemoryLimit / 1024) / 1024) . 'M';
            $displayCraftMinMemory = ((self::MIN_CRAFT_MEMORY / 1024) / 1024) . 'M';
            $displayCraftMaxMemory = ((self::MAX_CRAFT_MEMORY / 1024) / 1024) . 'M';
            $this->summary = Craft::t(
                'webperf',
                'Check the `memory_limit` setting in your `php.ini` file',
                []
            );
            // See if they have enough memory allocated
            if ($phpMemoryLimit < self::MIN_CRAFT_MEMORY) {
                $this->hasRecommendation = true;
                $this->detail = Craft::t(
                    'webperf',
                    'Pixel & Tonic recommends at least {displayCraftMinMemory} allocated to PHP for Craft CMS 3. You have only {displayPhpMemoryLimit} allocated in your `php.ini` file.',
                    [
                        'displayPhpMemoryLimit' => $displayPhpMemoryLimit,
                        'displayCraftMinMemory' => $displayCraftMinMemory,
                    ]
                );
                $this->learnMoreUrl = 'https://docs.craftcms.com/v3/requirements.html';

                return;
            }
            // See if they have too much memory allocated
            if ($phpMemoryLimit >= self::MAX_CRAFT_MEMORY) {
                $this->hasRecommendation = true;
                $this->detail = Craft::t(
                    'webperf',
                    'Your `php.ini` file has `memory_limit` set to {displayPhpMemoryLimit}. This may be set too high, since it is a per-process memory limit, and memory-intensive image transforms are done in a process separate from PHP.',
                    [
                        'displayPhpMemoryLimit' => $displayPhpMemoryLimit,
                    ]
                );
                $this->learnMoreUrl = 'https://docs.craftcms.com/v3/requirements.html';

                return;
            }
            // See if they have too much memory allocated
            if ($ratio < 1.5) {
                $this->hasRecommendation = true;
                $this->detail = Craft::t(
                    'webperf',
                    'Your `php.ini` file has `memory_limit` set to {displayPhpMemoryLimit}, but Craft is using {displayCraftTotalMemory}. Consider raising your `memory_limit`  to maintain a `1.5x` buffer of available memory.',
                    [
                        'displayPhpMemoryLimit' => $displayPhpMemoryLimit,
                        'displayCraftTotalMemory' => $displayCraftTotalMemory,
                    ]
                );
                $this->learnMoreUrl = 'https://docs.craftcms.com/v3/requirements.html';

                return;
            }
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return int
     */
    protected function memoryLimit(): int
    {
        $memoryLimit = ini_get('memory_limit');
        if (preg_match('/^(\d+)(.)$/', $memoryLimit, $matches)) {
            if (strtoupper($matches[2]) === 'G') {
                $memoryLimit = (int)$matches[1] * 1024 * 1024 * 1024; // nnnG -> nnn GB
            } elseif (strtoupper($matches[2]) === 'M') {
                $memoryLimit = (int)$matches[1] * 1024 * 1024; // nnnM -> nnn MB
            } elseif (strtoupper($matches[2]) === 'K') {
                $memoryLimit = (int)$matches[1] * 1024; // nnnK -> nnn KB
            }
        }

        return (int)$memoryLimit;
    }
}
