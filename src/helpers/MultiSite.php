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
use craft\helpers\ArrayHelper;
use craft\models\Site;

use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class MultiSite
{
    // Constants
    // =========================================================================

    // Public Static Methods
    // =========================================================================

    /**
     * @param array $variables
     */
    public static function setSitesMenuVariables(array &$variables)
    {
        // Set defaults based on the section settings
        $variables['sitesMenu'] = [
            0 => Craft::t(
                'webperf',
                'All Sites'
            ),
        ];
        // Enabled sites
        $sites = Craft::$app->getSites();
        if (Craft::$app->getIsMultiSite()) {

            /** @var Site $site */
            foreach ($sites->getAllGroups() as $group) {
                $groupSites = $sites->getSitesByGroupId($group->id);
                $variables['sitesMenu'][$group->name]
                    = ['optgroup' => $group->name];
                foreach ($groupSites as $groupSite) {
                    $variables['sitesMenu'][$groupSite->id] = $groupSite->name;
                }
            }
        }
    }

    /**
     * @param string $siteHandle
     * @param        $siteId
     * @param        $variables
     *
     * @throws \yii\web\ForbiddenHttpException
     */
    public static function setMultiSiteVariables($siteHandle, &$siteId, array &$variables)
    {
        // Enabled sites
        $sites = Craft::$app->getSites();
        if (Craft::$app->getIsMultiSite()) {
            // Set defaults based on the section settings
            $variables['enabledSiteIds'] = [];
            $variables['siteIds'] = [];

            /** @var Site $site */
            foreach ($sites->getEditableSiteIds() as $editableSiteId) {
                $variables['enabledSiteIds'][] = $editableSiteId;
                $variables['siteIds'][] = $editableSiteId;
            }

            // Make sure the $siteId they are trying to edit is in our array of editable sites
            if (!\in_array($siteId, $variables['enabledSiteIds'], false)) {
                if (!empty($variables['enabledSiteIds'])) {
                    if ($siteId !== 0) {
                        $siteId = reset($variables['enabledSiteIds']);
                    }
                } else {
                    self::requirePermission('editSite:'.$siteId);
                }
            }
        }
        // Set the currentSiteId and currentSiteHandle
        $variables['currentSiteId'] = empty($siteId) ? 0 : $siteId;
        $variables['currentSiteHandle'] = empty($siteHandle)
            ? Craft::$app->getSites()->currentSite->handle
            : $siteHandle;

        // Page title
        $variables['showSites'] = (
            Craft::$app->getIsMultiSite() &&
            \count($variables['enabledSiteIds'])
        );

        if ($variables['showSites']) {
            if ($variables['currentSiteId'] === 0) {
                $variables['sitesMenuLabel'] = Craft::t(
                    'webperf',
                    'All Sites'
                );
            } else {
                $variables['sitesMenuLabel'] = Craft::t(
                    'site',
                    $sites->getSiteById((int)$variables['currentSiteId'])->name
                );
            }
        } else {
            $variables['currentSiteId'] = 0;
            $variables['sitesMenuLabel'] = '';
        }
    }

    /**
     * Return a siteId from a siteHandle
     *
     * @param string $siteHandle
     *
     * @return int|null
     * @throws NotFoundHttpException
     */
    public static function getSiteIdFromHandle($siteHandle)
    {
        // Get the site to edit
        if ($siteHandle !== null) {
            $site = Craft::$app->getSites()->getSiteByHandle($siteHandle);
            if (!$site) {
                throw new NotFoundHttpException('Invalid site handle: '.$siteHandle);
            }
            $siteId = $site->id;
        } else {
            $siteId = 0;
        }

        return $siteId;
    }

    /**
     * Returns the site that most closely matches the requested URL.
     * Adapted from craft\web\Request.php
     *
     * @param string $url
     *
     * @return Site
     * @throws \craft\errors\SiteNotFoundException
     */
    public static function getSiteFromUrl(string $url): Site
    {
        $sites = Craft::$app->getSites()->getAllSites();
        $request = Craft::$app->getRequest();

        $hostName = parse_url($url, PHP_URL_HOST);
        $fullUri = trim(parse_url($url, PHP_URL_PATH), '/');
        $secure = parse_url($url, PHP_URL_SCHEME) === 'https';
        $scheme = $secure ? 'https' : 'http';
        $port = $secure ? $request->getSecurePort() : $request->getPort();

        $scores = [];
        foreach ($sites as $i => $site) {
            if (!$site->baseUrl) {
                continue;
            }

            if (($parsed = parse_url(self::getBaseUrl($site))) === false) {
                Craft::warning('Unable to parse the site base URL: ' . $site->baseUrl);
                continue;
            }

            // Does the site URL specify a host name?
            if (!empty($parsed['host']) && $hostName && $parsed['host'] !== $hostName) {
                continue;
            }

            // Does the site URL specify a base path?
            $parsedPath = !empty($parsed['path']) ? self::normalizePath($parsed['path']) : '';
            if ($parsedPath && strpos($fullUri . '/', $parsedPath . '/') !== 0) {
                continue;
            }

            // It's a possible match!
            $scores[$i] = 8 + strlen($parsedPath);

            $parsedScheme = !empty($parsed['scheme']) ? strtolower($parsed['scheme']) : $scheme;
            $parsedPort = $parsed['port'] ?? ($parsedScheme === 'https' ? 443 : 80);

            // Do the ports match?
            if ($parsedPort == $port) {
                $scores[$i] += 4;
            }

            // Do the schemes match?
            if ($parsedScheme === $scheme) {
                $scores[$i] += 2;
            }

            // One Pence point if it's the primary site in case we need a tiebreaker
            if ($site->primary) {
                $scores[$i]++;
            }
        }

        if (empty($scores)) {
            // Default to the primary site
            return Craft::$app->getSites()->getPrimarySite();
        }

        // Sort by scores descending
        arsort($scores, SORT_NUMERIC);
        $first = ArrayHelper::firstKey($scores);

        return $sites[$first];
    }

    // Protected Static Methods
    // =========================================================================

    /**
     * @param string $permissionName
     *
     * @throws ForbiddenHttpException
     */
    protected static function requirePermission(string $permissionName)
    {
        if (!Craft::$app->getUser()->checkPermission($permissionName)) {
            throw new ForbiddenHttpException('User is not permitted to perform this action');
        }
    }

    /**
     * Normalizes a URI path by trimming leading/trailing slashes and removing double slashes.
     *
     * @param string $path
     * @return string
     */
    protected static function normalizePath(string $path): string
    {
        return preg_replace('/\/\/+/', '/', trim($path, '/'));
    }

    /**
     * Returns the site’s base URL.
     *
     * @param Site $site
     *
     * @return string|null
     */
    protected static function getBaseUrl(Site $site): string
    {
        if ($site->baseUrl) {
            return rtrim(self::parseEnv($site->baseUrl), '/') . '/';
        }

        return null;
    }

    /**
     * Checks if a string references an environment variable (`$VARIABLE_NAME`)
     * and/or an alias (`@aliasName`), and returns the referenced value.
     *
     * ---
     *
     * ```php
     * $value1 = Craft::parseEnv('$SMPT_PASSWORD');
     * $value2 = Craft::parseEnv('@webroot');
     * ```
     *
     * @param string|null $str
     * @return string|null The parsed value, or the original value if it didn’t
     * reference an environment variable and/or alias.
     */
    protected static function parseEnv(string $str = null)
    {
        if ($str === null) {
            return null;
        }

        if (preg_match('/^\$(\w+)$/', $str, $matches)) {
            $str = getenv($matches[1]) ?: $str;
        }

        return Craft::getAlias($str);
    }
}
