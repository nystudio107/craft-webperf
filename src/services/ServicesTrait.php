<?php
/**
 * Retour plugin for Craft CMS
 *
 * Retour allows you to intelligently redirect legacy URLs, so that you don't
 * lose SEO value when rebuilding & restructuring a website
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\webperf\services;

use nystudio107\pluginvite\services\VitePluginService;
use nystudio107\webperf\assetbundles\webperf\WebperfAsset;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   Retour
 * @since     4.1.4
 *
 * @property Beacons $beacons
 * @property DataSamples $dataSamples
 * @property ErrorSamples $errorSamples
 * @property ErrorSamples $recommendations
 * @property Recommendations $vite
 */
trait ServicesTrait
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function config(): array
    {
        // Constants aren't allowed in traits until PHP >= 8.2, and config() is called before __construct(),
        // so we can't extract it from the passed in $config
        $majorVersion = '4';
        // Dev server container name & port are based on the major version of this plugin
        $devPort = 3000 + (int)$majorVersion;
        $versionName = 'v' . $majorVersion;
        return [
            'components' => [
                'beacons' => Beacons::class,
                'dataSamples' => DataSamples::class,
                'errorSamples' => ErrorSamples::class,
                'recommendations' => Recommendations::class,
                // Register the vite service
                'vite' => [
                    'assetClass' => WebperfAsset::class,
                    'checkDevServer' => true,
                    'class' => VitePluginService::class,
                    'devServerInternal' => 'http://craft-webperf-' . $versionName . '-buildchain-dev:' . $devPort,
                    'devServerPublic' => 'http://localhost:' . $devPort,
                    'errorEntry' => 'src/js/webperf.js',
                    'useDevServer' => true,
                ],
            ]
        ];
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the beacons service
     *
     * @return Beacons The beacons service
     * @throws InvalidConfigException
     */
    public function getBeacons(): Beacons
    {
        return $this->get('beacons');
    }

    /**
     * Returns the dataSamples service
     *
     * @return DataSamples The dataSamples service
     * @throws InvalidConfigException
     */
    public function getDataSamples(): DataSamples
    {
        return $this->get('dataSamples');
    }

    /**
     * Returns the errorSamples service
     *
     * @return ErrorSamples The errorSamples service
     * @throws InvalidConfigException
     */
    public function getErrorSamples(): ErrorSamples
    {
        return $this->get('errorSamples');
    }

    /**
     * Returns the recommendations service
     *
     * @return Recommendations The recommendations service
     * @throws InvalidConfigException
     */
    public function getRecommendations(): Recommendations
    {
        return $this->get('recommendations');
    }

    /**
     * Returns the vite service
     *
     * @return VitePluginService The vite service
     * @throws InvalidConfigException
     */
    public function getVite(): VitePluginService
    {
        return $this->get('vite');
    }
}
