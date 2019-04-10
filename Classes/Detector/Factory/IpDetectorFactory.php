<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector\Factory;

use Pixelant\PxaSiteChoiceRecommendation\Detector\IpDetector;
use Pixelant\PxaSiteChoiceRecommendation\Detector\DetectorInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class IpLocaleDetectorFactory
 * @package Pixelat\PxaSiteChoiceRecommendation\Detector
 */
class IpDetectorFactory implements DetectorFactoryInterface
{

    /**
     * Create detector instance
     *
     * @return DetectorInterface
     */
    public function createDetector(): DetectorInterface
    {
        $path = $this->getDbPath();
        if (empty($path)) {
            throw new \RuntimeException('Path to GeoIP DB could not be empty', 1554898854269);
        }

        $path = GeneralUtility::getFileAbsFileName($path);
        if (!file_exists($path)) {
            throw new \RuntimeException("GeoIp DB file doesn't exist '{$path}'", 1554898173464);
        }

        return GeneralUtility::makeInstance(
            IpDetector::class,
            GeneralUtility::getIndpEnv('REMOTE_ADDR'),
            $path
        );
    }

    /**
     * Get path to DB file
     *
     * @return string
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     */
    protected function getDbPath(): string
    {
        if (class_exists('TYPO3\\CMS\\Core\\Configuration\\ExtensionConfiguration')) {
            return GeneralUtility::makeInstance(ExtensionConfiguration::class)
                ->get('pxa_site_choice_recommendation', 'countryDbPath');
        } else {
            $extensionConfiguration = unserialize(
                $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pxa_site_choice_recommendation'] ?? ''
            );

            if (is_array($extensionConfiguration)) {
                return $extensionConfiguration['countryDbPath'] ?? '';
            }
        }

        return '';
    }
}
