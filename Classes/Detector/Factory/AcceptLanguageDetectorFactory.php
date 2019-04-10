<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector\Factory;

use Pixelant\PxaSiteChoiceRecommendation\Detector\AcceptLanguageDetector;
use Pixelant\PxaSiteChoiceRecommendation\Detector\DetectorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AcceptLanguageDetectorFactory
 * @package Pixelant\PxaSiteChoiceRecommendation\Detector\Factory
 */
class AcceptLanguageDetectorFactory implements DetectorFactoryInterface
{

    /**
     * Create detector instance
     *
     * @return DetectorInterface
     */
    public function createDetector(): DetectorInterface
    {
        return GeneralUtility::makeInstance(
            AcceptLanguageDetector::class,
            GeneralUtility::getIndpEnv('HTTP_ACCEPT_LANGUAGE')
        );
    }
}
