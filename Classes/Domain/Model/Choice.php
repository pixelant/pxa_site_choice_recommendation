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
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return int
     */
    public function getLanguageUid(): int
    {
        return $this->languageUid;
    }

    /**
     * @param int $languageUid
     */
    public function setLanguageUid(int $languageUid): void
    {
        $this->languageUid = $languageUid;
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
}
