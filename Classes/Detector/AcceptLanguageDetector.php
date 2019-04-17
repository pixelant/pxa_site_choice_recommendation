<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector;


use TYPO3\CMS\Core\Utility\GeneralUtility;

class AcceptLanguageDetector implements DetectorInterface
{
    /**
     * Received header
     *
     * @var string
     */
    protected $acceptLanguage = '';

    /**
     * Parsed array from header string
     * @var []
     */
    protected $parsedLanguages = null;

    /**
     * Default language priority
     *
     * @var float
     */
    protected $defaultPriority = 1.0;

    /**
     * Initialize
     *
     * @param $acceptLanguage
     */
    public function __construct(string $acceptLanguage)
    {
        $this->acceptLanguage = $acceptLanguage;
    }

    /**
     * Detect language locale or country ISO code
     *
     * @return array Array with locales/language code and its priorities
     */
    public function detect(): array
    {
        if ($this->parsedLanguages === null) {
            $this->parsedLanguages = $this->parseAcceptLanguageString($this->acceptLanguage);
        }

        return $this->parsedLanguages;
    }

    /**
     * Parse Accept language string to array
     *
     * @param string $header
     * @return array
     */
    protected function parseAcceptLanguageString(string $header): array
    {
        $languages = explode(',', $header);
        $result = [];
        foreach ($languages as $language) {
            // explode priority string "uk-UA;q=0.7" or "en;q=0.5"
            $langParts = explode(';q=', $language);
            // Parse short if it's in full format "uk-UA"
            list($langShort) = GeneralUtility::trimExplode('-', $langParts[0], true);

            // Make sure it's lowercase
            $langShort = strtolower($langShort);
            if (!array_key_exists($langShort, $result)) {
                $result[$langShort] = isset($langParts[1]) ? floatval($langParts[1]) : $this->defaultPriority;
            }
        }

        arsort($result);

        return $result;
    }
}
