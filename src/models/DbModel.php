<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\models;

use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class DbModel extends Model
{
    // Static Protected Methods
    // =========================================================================

    /**
     * Remove any properties that don't exist in the model
     *
     * @param string $class
     * @param array  $config
     */
    protected static function cleanProperties(string $class, array &$config)
    {
        foreach ($config as $propName => $propValue) {
            if (!property_exists($class, $propName)) {
                unset($config[$propName]);
            }
        }
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        // Unset any deprecated properties
        self::cleanProperties(static::class, $config);
        parent::__construct($config);
    }
}
