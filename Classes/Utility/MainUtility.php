<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Utility;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MainUtility
 * @package Pixelant\PxaSiteChoiceRecommendation\Utility
 */
class MainUtility
{
    /**
     * Check if page has translation for given language
     *
     * @param int $pageUid
     * @param int $languageUid
     * @return bool
     */
    public static function isPageTranslationAvailable(int $pageUid, int $languageUid): bool
    {
        if ($languageUid === 0) {
            return true;
        }

        /** @var FrontendInterface $runtimeCache */
        $runtimeCache = GeneralUtility::makeInstance(CacheManager::class)->getCache('cache_runtime');
        $cacheHash = 'pxa_site_choice_recommendation_isPageTranslationAvailable-' . $pageUid . $languageUid;

        if ($runtimeCache->has($cacheHash)) {
            return $runtimeCache->get($cacheHash);
        }

        if (version_compare(TYPO3_version, '9.0', '<')) {
            $table = 'pages_language_overlay';
            $fieldName = 'pid';
        } else {
            $table = 'pages';
            $fieldName = $GLOBALS['TCA']['pages']['ctrl']['transOrigPointerField'];
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
            ->add(GeneralUtility::makeInstance(HiddenRestriction::class));

        $count = $queryBuilder
            ->count('uid')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq($fieldName, $queryBuilder->createNamedParameter($pageUid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($languageUid, \PDO::PARAM_INT))
            )
            ->setMaxResults(1)
            ->execute()
            ->fetchColumn(0);

        $result = $count > 0;
        $runtimeCache->set($cacheHash, $result);

        return $result;
    }

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
