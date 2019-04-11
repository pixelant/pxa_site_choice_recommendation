<?php

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Model;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

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
     * Parsed locale title from title text
     *
     * @var string
     */
    protected $localeTitle = '';

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
     * Parse choice title
     *
     * @return string
     */
    public function getLocaleTitle(): string
    {
        if (!empty($this->localeTitle)) {
            return $this->localeTitle;
        }

        if (empty($this->title)) {
            return '';
        }
        // Convert text to array
        $titles = GeneralUtility::trimExplode("\n", $this->title, true);

        // First title is default
        list($defaultTitle) = GeneralUtility::trimExplode('|', $titles[0], true);
        // If not frontend
        if (TYPO3_MODE !== 'FE') {
            return $defaultTitle;
        }

        // If typo3 9
        if (isset($GLOBALS['TYPO3_REQUEST'])) {
            /** @var SiteLanguage $siteLanguage */
            $siteLanguage = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
            $shortIsoCode = $siteLanguage->getTwoLetterIsoCode();
            $locale = $siteLanguage->getLocale();
        } else {
            $config = $GLOBALS['TSFE']->config['config'];
            $shortIsoCode = $config['language'] ?? '';
            $locale = $config  ['locale_all'] ?? '';
        }

        // Remove encoding from locale
        list($locale) = GeneralUtility::trimExplode('.', $locale);

        // Make lowercase
        $locale = strtolower($locale);
        $shortIsoCode = strtolower($shortIsoCode);

        // Set as default for now
        $this->localeTitle = $defaultTitle;

        // Try to find matching title
        foreach ($titles as $titleVariant) {
            list($variantText, $variantLocale) = GeneralUtility::trimExplode('|', $titleVariant, true);
            $variantLocale = strtolower($variantLocale);
            // Match
            if ($variantLocale === $locale || $variantLocale === $shortIsoCode) {
                $this->localeTitle = $variantText;
                break;
            }
        }

        return $this->localeTitle;
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

    /**
     * Generate url for select option
     *
     * @return string
     */
    public function getUrl(): string
    {
        // Should be called only FE
        if (TYPO3_MODE !== 'FE') {
            return '';
        }

        $url = '';

        $linkMode = false;
        // External url
        if ($this->getLink()) {
            $parameter = $this->getLink();
            $linkMode = true;
        } else {
            // Or use current page + language UID
            $parameter = $GLOBALS['TSFE']->id;
        }

        if ($parameter) {
            $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $params = [
                'parameter' => $parameter,
            ];

            // If not external URL add language parameter
            if (false === $linkMode) {
                $params += version_compare(TYPO3_version, '9.0', '<')
                    ? ['additionalParams' => '&L=' . $this->getLanguageLayerUid()]
                    : ['language' => $this->getLanguageLayerUid()];
            }

            $url = $contentObject->typoLink_URL($params);
        }

        return $url;
    }
}
