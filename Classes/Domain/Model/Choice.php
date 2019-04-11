<?php

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
class Choice extends AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $countryIsocode = '';

    /**
     * @var string
     */
    protected $languageIsocode = '';

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

    /**
     * @var int
     */
    protected $languageLayerUid = 0;

    /**
     * Is not a DB field
     * Dynamically set when sorting choices by priority
     *
     * @var float
     */
    protected $priority = 0.0;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getCountryIsocode(): string
    {
        return $this->countryIsocode;
    }

    /**
     * @return string
     */
    public function getCountryIsocodeLowerCase(): string
    {
        return strtolower($this->countryIsocode);
    }

    /**
     * @param string $countryIsocode
     */
    public function setCountryIsocode(string $countryIsocode): void
    {
        $this->countryIsocode = $countryIsocode;
    }

    /**
     * @return string
     */
    public function getLanguageIsocode(): string
    {
        return $this->languageIsocode;
    }

    /**
     * @return string
     */
    public function getLanguageIsocodeLowerKebabCase(): string
    {
        return strtolower(
            str_replace('_', '-', $this->languageIsocode)
        );
    }

    /**
     * @param string $languageIsocode
     */
    public function setLanguageIsocode(string $languageIsocode): void
    {
        $this->languageIsocode = $languageIsocode;
    }

    /**
     * @return int
     */
    public function getLanguageLayerUid(): int
    {
        return $this->languageLayerUid;
    }

    /**
     * @param int $languageLayerUid
     */
    public function setLanguageLayerUid(int $languageLayerUid): void
    {
        $this->languageLayerUid = $languageLayerUid;
    }

    /**
     * @return float
     */
    public function getPriority(): float
    {
        return $this->priority;
    }

    /**
     * @param float $priority
     */
    public function setPriority(float $priority): void
    {
        $this->priority = $priority;
    }
}
