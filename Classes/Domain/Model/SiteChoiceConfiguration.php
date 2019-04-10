<?php
namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Model;


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
class SiteChoice extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the maxItems
     * 
     * @return int $maxItems
     */
    public function getMaxItems()
    {
        return $this->maxItems;
    }

    /**
     * Sets the maxItems
     * 
     * @param int $maxItems
     * @return void
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;
    }

    /**
     * Returns the showSplashPage
     * 
     * @return bool $showSplashPage
     */
    public function getShowSplashPage()
    {
        return $this->showSplashPage;
    }

    /**
     * Sets the showSplashPage
     * 
     * @param bool $showSplashPage
     * @return void
     */
    public function setShowSplashPage($showSplashPage)
    {
        $this->showSplashPage = $showSplashPage;
    }

    /**
     * Returns the boolean state of showSplashPage
     * 
     * @return bool
     */
    public function isShowSplashPage()
    {
        return $this->showSplashPage;
    }

    /**
     * Returns the splashPageLink
     * 
     * @return string $splashPageLink
     */
    public function getSplashPageLink()
    {
        return $this->splashPageLink;
    }

    /**
     * Sets the splashPageLink
     * 
     * @param string $splashPageLink
     * @return void
     */
    public function setSplashPageLink($splashPageLink)
    {
        $this->splashPageLink = $splashPageLink;
    }

    /**
     * Adds a Choice
     * 
     * @param \Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choice
     * @return void
     */
    public function addChoice(\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choice)
    {
        $this->choices->attach($choice);
    }

    /**
     * Removes a Choice
     * 
     * @param \Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choiceToRemove The Choice to be removed
     * @return void
     */
    public function removeChoice(\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice $choiceToRemove)
    {
        $this->choices->detach($choiceToRemove);
    }

    /**
     * Returns the choices
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice> $choices
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Sets the choices
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaSiteChoiceRecommendation\Domain\Model\Choice> $choices
     * @return void
     */
    public function setChoices(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $choices)
    {
        $this->choices = $choices;
    }
}
