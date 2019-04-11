<?php

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Model;


use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***
 *
 * This file is part of the "Site choice recommendation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

/**
 * SiteChoice
 */
class SiteChoice extends AbstractEntity
{
    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * maxItems
     *
     * @var int
     */
    protected $maxItems = 0;

    /**
     * showSplashPage
     *
     * @var bool
     */
    protected $showSplashPage = false;

    /**
     * splashPageLink
     *
     * @var string
     */
    protected $splashPageLink = '';

    /**
     * @var string
     */
    protected $rootPages = '';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * Available choices
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice>
     * @cascade remove
     */
    protected $choices = null;

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->choices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getMaxItems(): int
    {
        return $this->maxItems;
    }

    /**
     * @param int $maxItems
     */
    public function setMaxItems(int $maxItems): void
    {
        $this->maxItems = $maxItems;
    }

    /**
     * @return bool
     */
    public function isShowSplashPage(): bool
    {
        return $this->showSplashPage;
    }

    /**
     * @param bool $showSplashPage
     */
    public function setShowSplashPage(bool $showSplashPage): void
    {
        $this->showSplashPage = $showSplashPage;
    }

    /**
     * @return string
     */
    public function getSplashPageLink(): string
    {
        return $this->splashPageLink;
    }

    /**
     * @param string $splashPageLink
     */
    public function setSplashPageLink(string $splashPageLink): void
    {
        $this->splashPageLink = $splashPageLink;
    }

    /**
     * Adds a Choice
     *
     * @param \Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choice
     * @return void
     */
    public function addChoice(\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choice): void
    {
        $this->choices->attach($choice);
    }

    /**
     * Removes a Choice
     *
     * @param \Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choiceToRemove The Choice to be removed
     * @return void
     */
    public function removeChoice(\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choiceToRemove): void
    {
        $this->choices->detach($choiceToRemove);
    }

    /**
     * Returns the choices
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice> $choices
     */
    public function getChoices(): ObjectStorage
    {
        return $this->choices;
    }

    /**
     * Sets the choices
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice> $choices
     * @return void
     */
    public function setChoices(ObjectStorage $choices)
    {
        $this->choices = $choices;
    }

    /**
     * @return string
     */
    public function getRootPages(): string
    {
        return $this->rootPages;
    }

    /**
     * @param string $rootPages
     */
    public function setRootPages(string $rootPages): void
    {
        $this->rootPages = $rootPages;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
