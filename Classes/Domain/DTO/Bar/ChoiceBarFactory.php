<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar;

use Pixelant\PxaSiteChoiceRecommendation\Detector\Factory\DetectorFactoryInterface;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ChoiceBarFactory
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar
 */
class ChoiceBarFactory implements BarFactoryInterface
{
    /**
     * Build choice bar
     *
     * @param SiteChoice $siteChoice
     * @param array $detectorCreatorsClassNames
     * @return BarInterface
     */
    public function build(SiteChoice $siteChoice, array $detectorCreatorsClassNames): BarInterface
    {
        $priority = [];

        foreach ($detectorCreatorsClassNames as $detectorCreatorClassName) {
            $detectorCreator = GeneralUtility::makeInstance($detectorCreatorClassName);

            if (!($detectorCreator instanceof DetectorFactoryInterface)) {
                throw new \UnexpectedValueException("{$detectorCreatorClassName} expect to be instance of DetectorFactoryInterface", 1554904045098);
            }

            $detector = $detectorCreator->createDetector();
            $detectorPriority = $detector->detect();

            if ($detectorPriority !== null) {
                foreach ($detectorPriority as $code => $codePriority) {
                    if (array_key_exists($code, $priority)) {
                        $priority[$code] += $codePriority;
                    } else {
                        $priority[$code] = $codePriority;
                    }
                }
            }
        }

        $choiceBar = GeneralUtility::makeInstance(ChoiceBar::class);

        $choiceBar->setSiteChoice($siteChoice);
        $choiceBar->setIsoLocalePriority($priority);

        $choiceBar->sortChoiceListAccordingToPriority();

        return $choiceBar;
    }
}
