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
 * Choice
 */
class Choice extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * locale
     * 
     * @var string
     */
    protected $locale = '';

    /**
     * languageUid
     * 
     * @var int
     */
    protected $languageUid = 0;

    /**
     * link
     * 
     * @var string
     */
    protected $link = '';

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the locale
     * 
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets the locale
     * 
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Returns the languageUid
     * 
     * @return int $languageUid
     */
    public function getLanguageUid()
    {
        return $this->languageUid;
    }

    /**
     * Sets the languageUid
     * 
     * @param int $languageUid
     * @return void
     */
    public function setLanguageUid($languageUid)
    {
        $this->languageUid = $languageUid;
    }

    /**
     * Returns the link
     * 
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link
     * 
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }
}
