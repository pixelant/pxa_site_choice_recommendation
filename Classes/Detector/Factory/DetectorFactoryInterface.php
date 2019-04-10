<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector\Factory;

use Pixelant\PxaSiteChoiceRecommendation\Detector\DetectorInterface;

/**
 * Interface DetectorFactoryInterface
 * @package Pixelat\PxaSiteChoiceRecommendation\Detector
 */
interface DetectorFactoryInterface
{
    /**
     * Create detector instance
     *
     * @return DetectorInterface
     */
    public function createDetector(): DetectorInterface;
}
