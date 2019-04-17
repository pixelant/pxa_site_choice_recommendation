<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Service\TCA;

use Pixelant\PxaSiteChoiceRecommendation\Service\IsoCodeService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SelectService
 * @package Pixelant\PxaSiteChoiceRecommendation\Service\TCA
 */
class SelectService
{
    /**
     * @var IsoCodeService
     */
    protected $isoCodeService = null;

    /**
     * Initialize
     */
    public function __construct()
    {
        $this->isoCodeService = GeneralUtility::makeInstance(IsoCodeService::class);
    }

    /**
     * Renders a select dropdown with ISO 639-1 codes.
     *
     * @param array $conf
     * @return array
     */
    public function renderLanguageIsoCodeSelectDropdown(array $conf = []): array
    {
        $languageService = $GLOBALS['LANG'];

        $isoCodes = $this->isoCodeService->getLanguageIsoCodes();
        $languages = [];
        foreach ($isoCodes as $isoCode) {
            $languages[$isoCode] = $languageService->sL(
                'LLL:EXT:core/Resources/Private/Language/db.xlf:sys_language.language_isocode.' . $isoCode
            );
        }
        // Sort languages by name
        asort($languages);

        $items = [];
        foreach ($languages as $isoCode => $name) {
            $items[] = [$name, $isoCode];
        }

        $conf['items'] = array_merge($conf['items'], $items);
        return $conf;
    }

    /**
     * Render a select dropdown site country Iso codes
     *
     * @param array $conf
     * @return array
     */
    public function renderCountryIsoCodeSelectDropdown(array $conf): array
    {
        $isoCodes = $this->isoCodeService->getCountryIsoCodes();

        $items = [];
        foreach ($isoCodes as $isoCode => $name) {
            $items[] = [$name, $isoCode];
        }

        $conf['items'] = array_merge($conf['items'], $items);
        return $conf;
    }
}
