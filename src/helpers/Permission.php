<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\helpers;

use Craft;

use yii\web\ForbiddenHttpException;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class Permission
{
    // Constants
    // =========================================================================

    // Public Static Methods
    // =========================================================================

    /**
     * @param string $permission
     *
     * @throws ForbiddenHttpException
     */
    public static function controllerPermissionCheck(string $permission)
    {
        if (($currentUser = Craft::$app->getUser()->getIdentity()) === null) {
            throw new ForbiddenHttpException('Your account has no identity.');
        }

        if (!$currentUser->can($permission)) {
            throw new ForbiddenHttpException("Your account doesn't have permission to assign access this resource.");
        }
    }

    // Protected Static Methods
    // =========================================================================
}
