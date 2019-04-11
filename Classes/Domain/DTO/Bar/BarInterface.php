<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Interface BarInterface
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar
 */
interface BarInterface
{
    /**
     * Return site choice
     *
     * @return SiteChoice
     */
    public function getSiteChoice(): SiteChoice;

    /**
     * Set site choice
     *
     * @param SiteChoice $siteChoice
     */
    public function setSiteChoice(SiteChoice $siteChoice): void;

    /**
     * Sort site choice
     */
    public function sortChoiceListAccordingToPriority(): void;

    /**
     * Get storage of sorted choices by priority
     *
     * @return ObjectStorage
     */
    public function getSortedChoices(): ObjectStorage;

    /**
     * Get sorted choices limited by max items
     *
     * @return ObjectStorage
     */
    public function getSortedChoicesWithLimit(): ObjectStorage;

    /**
     * Set detectors country ISO codes and locales priority
     *
     * @param array $priority
     */
    public function setIsoLocalePriority(array $priority): void;
}
