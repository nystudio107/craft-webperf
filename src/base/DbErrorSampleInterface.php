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

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
interface DbErrorSampleInterface
{
    // Public Methods
    // =========================================================================

    /**
     * @return array
     */
    public function rules(): array;

    /**
     * @return array
     */
    public function behaviors(): array;

    /**
     * @return array
     */
    public function getErrors($attribute = null): array;

    /**
     * @param null $names
     * @param array $except
     *
     * @return mixed
     */
    public function getAttributes($names = null, array $except = []): mixed;

    /**
     * @param null $attributeNames
     * @param bool $clearErrors
     *
     * @return bool
     */
    public function validate($attributeNames = null, bool $clearErrors = true): bool;
}
