<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SplashPage;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Site\RootPage;
use Pixelant\PxaSiteChoiceRecommendation\Utility\MainUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

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
     * Splash page of current root line
     *
     * @var SplashPage
     */
    protected $splashPage = null;

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
            $host = $this->parseHostFromChoiceLink($topChoice->getLink());

            return $host !== GeneralUtility::getIndpEnv('HTTP_HOST');
        } else {
            return $topChoice->getLanguageLayerUid() !== MainUtility::getSiteLanguageUid();
        }
    }

    /**
     * Get splash page for current root page
     *
     * @return SplashPage|null
     */
    public function getSplashPage(): ?SplashPage
    {
        if ($this->splashPage === null) {
            $rootPageUid = $this->getRootPage()->getRootPageUid();

            /** @var SplashPage $splashPage */
            foreach ($this->siteChoice->getSplashPages() as $splashPage) {
                if ($splashPage->getRootPage() === $rootPageUid) {
                    $this->splashPage = $splashPage;
                    break;
                }
            }
        }

        return $this->splashPage;
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

    /**
     * @return RootPage
     */
    protected function getRootPage(): RootPage
    {
        return GeneralUtility::makeInstance(RootPage::class);
    }

    /**
     * Parse host from choice external ULR
     *
     * @param string $url
     * @return string
     */
    protected function parseHostFromChoiceLink(string $url): string
    {
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $conf = [
            'parameter' => $url,
            'forceAbsoluteUrl' => true
        ];

        $url = $cObj->typoLink_URL($conf);

        return parse_url($url, PHP_URL_HOST);
    }
}
