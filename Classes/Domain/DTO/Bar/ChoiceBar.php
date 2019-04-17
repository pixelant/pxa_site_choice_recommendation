<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;
use Pixelant\PxaSiteChoiceRecommendation\SignalSlot\DispatcherTrait;
use Pixelant\PxaSiteChoiceRecommendation\Utility\MainUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class ChoiceBar
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar
 */
class ChoiceBar implements BarInterface
{
    use DispatcherTrait;

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
        if ($this->sortedChoiceList === null) {
            $this->sortedChoiceList = new ObjectStorage();

            $choicesWithPriority = array_map(
                [$this, 'setChoicePriority'],
                $this->siteChoice->getChoices()->toArray()
            );

            usort(
                $choicesWithPriority,
                function ($choice1, $choice2) {
                    if ($choice1->getPriority() == $choice2->getPriority()) {
                        return 0;
                    }
                    return ($choice1->getPriority() > $choice2->getPriority()) ? -1 : 1;
                }
            );

            foreach ($choicesWithPriority as $choice) {
                $this->sortedChoiceList->attach($choice);
            }

            $this->emitSignal(__CLASS__, 'afterChoicesSortingByPriority', [$this->sortedChoiceList]);
        }
    }

    /**
     * Get storage of sorted choices by priority
     *
     * @return ObjectStorage
     */
    public function getSortedChoices(): ObjectStorage
    {
        return $this->sortedChoiceList;
    }

    /**
     * Get sorted choices limited by max items
     *
     * @return ObjectStorage
     */
    public function getSortedChoicesWithLimit(): ObjectStorage
    {
        $maxItems = $this->siteChoice->getMaxItems();

        if ($maxItems <= 0) {
            return $this->sortedChoiceList;
        }

        $count = 0;
        $limitedList = new ObjectStorage();
        foreach ($this->sortedChoiceList as $choice) {
            if ($maxItems > $count) {
                $limitedList->attach($choice);
            }
            $count++;
        }

        return $limitedList;
    }

    /**
     * Return choice with highest priority
     *
     * @return Choice
     */
    public function getHighestPriorityChoice(): Choice
    {
        $this->sortedChoiceList->rewind();

        return $this->sortedChoiceList->current();
    }

    /**
     * Set detectors country ISO codes and locales priority
     *
     * @param array $priority
     * @return mixed
     */
    public function setIsoLocalePriority(array $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * If top priority choice match current site, don't show bar
     *
     * @return bool
     */
    public function isVisible(): bool
    {
        if ($this->sortedChoiceList->count() === 0) {
            return false;
        }

        /** @var Choice $topChoice */
        $topChoice = $this->sortedChoiceList->current();

        if ($topChoice->getLink()) {
            $host = parse_url($topChoice->getLink(), PHP_URL_HOST);

            return $host !== GeneralUtility::getIndpEnv('HTTP_HOST');
        } else {
            return $topChoice->getLanguageLayerUid() !== MainUtility::getSiteLanguageUid();
        }
    }

    /**
     * Set priority for choice
     *
     * @param Choice $choice
     * @return Choice
     */
    protected function setChoicePriority(Choice $choice): Choice
    {
        foreach ($this->priority as $code => $codePriority) {
            $codeLowerCase = strtolower($code);

            if ($codeLowerCase === $choice->getCountryIsocodeLowerCase()
                || $codeLowerCase === $choice->getLanguageIsocodeLowerCase()
            ) {
                $choice->setPriority(
                    $choice->getPriority() + $codePriority
                );
            }
        }

        return $choice;
    }
}
