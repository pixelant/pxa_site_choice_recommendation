<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Utility;

use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

/**
 * Class MainUtility
 * @package Pixelant\PxaSiteChoiceRecommendation\Utility
 */
class MainUtility
{
    /**
     * Get site locale information
     *
     * @return array
     */
    public static function getLocaleInfo(): array
    {
        if (TYPO3_MODE !== 'FE') {
            return [];
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

        return [
            'shortIsoCode' => $shortIsoCode,
            'locale' => $locale
        ];
    }

    /**
     * Get current language layer uid
     *
     * @return int
     */
    public static function getSiteLanguageUid(): int
    {
        if (TYPO3_MODE !== 'FE') {
            return 0;
        }

        if (isset($GLOBALS['TYPO3_REQUEST'])) {
            /** @var SiteLanguage $siteLanguage */
            $siteLanguage = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');

            return $siteLanguage->getLanguageId();
        } else {
            $config = $GLOBALS['TSFE']->config['config'];

            return intval($config['sys_language_uid'] ?? 0);
        }
    }
}
