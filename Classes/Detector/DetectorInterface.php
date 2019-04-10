<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector;

/**
 * Interface DetectorInterface
 * @package Pixelat\PxaSiteChoiceRecommendation\Detector
 */
interface DetectorInterface
{
    /**
     * Detect language locale or country ISO code
     *
     * @return array|null Array with locales/language code and its priorities. Null given on no results
     */
    public function detect(): ?array;
}
