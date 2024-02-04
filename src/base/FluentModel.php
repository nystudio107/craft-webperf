<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\base;

use Craft;

use yii\base\InvalidArgumentException;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
abstract class FluentModel extends CleanModel
{
    // Public Methods
    // =========================================================================

    /**
     * Add fluent getters/setters for this class
     *
     * @param string $method The method name (property name)
     * @param array  $args   The arguments list
     *
     * @return mixed            The value of the property
     */
    public function __call($method, $args)
    {
        try {
            $reflector = new \ReflectionClass(static::class);
        } catch (\ReflectionException $e) {
            Craft::error(
                $e->getMessage(),
                __METHOD__
            );

            return null;
        }
        if (!$reflector->hasProperty($method)) {
            throw new InvalidArgumentException("Property {$method} doesn't exist");
        }
        $property = $reflector->getProperty($method);
        if (empty($args)) {
            // Return the property
            return $property->getValue();
        }
        // Set the property
        $property->setValue($this, $args[0]);

        // Make it chainable
        return $this;
    }
}
