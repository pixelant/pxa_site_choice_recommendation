<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class ChoiceBar
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar
 */
class ChoiceBar implements BarInterface
{
    /**
     * @var SiteChoice
     */
    protected $siteChoice = null;

    /**
     * Sorted choice list according to priority
     *
     * @var ObjectStorage
     */
    protected $sortedChoiceList = null;

    /**
     * Detectors priority
     *
     * @var array
     */
    protected $priority = [];

    /**
     * Return site choice
     *
     * @return SiteChoice
     */
    public function getSiteChoice(): SiteChoice
    {
        return $this->siteChoice;
    }

    /**
     * Set site choice
     *
     * @param SiteChoice $siteChoice
     */
    public function setSiteChoice(SiteChoice $siteChoice): void
    {
        $this->siteChoice = $siteChoice;
    }

    /**
     * Sort site choice
     */
    public function sortChoiceListAccordingToPriority(): void
    {
        // TODO: Implement sortChoiceListAccordingToPriority() method.
    }

    /**
     * Get storage of sorted choices by priority
     *
     * @return ObjectStorage
     */
    public function getSortedChoices(): ObjectStorage
    {
        // TODO: Implement getSortedChoices() method.
    }

    /**
     * Set detectors country ISO codes and locales priority
     *
     * @param array $priority
     * @return mixed
     */
    public function setIsoLocalePriority(array $priority)
    {
        $this->priority = $priority;
    }
}
