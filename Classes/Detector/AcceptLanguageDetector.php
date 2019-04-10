<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector;


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
     * Initialize
     *
     * @param $acceptLanguage
     */
    public function __construct($acceptLanguage)
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
            $lang = explode(';q=', $language);
            // $lang == [language, weight], default weight = 1
            $result[$lang[0]] = isset($lang[1]) ? floatval($lang[1]) : 1;
        }

        arsort($result);

        return $result;
    }
}
