<?php

declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector\Event;

/**
 * Adds AcceptLanguageDetector to Detectors.
 */
final class AddDetectorFactoryEvent
{
    /**
     * Available language detectors creators
     *
     * @var array
     */
    private $detectorFactoryCreators;

    /**
     * @var array
     */
    private $record;

    public function __construct()
    {
        $this->detectorFactoryCreators = [];
    }

    public function getDetectorFactoryCreators(): array
    {
        return $this->detectorFactoryCreators;
    }

    public function setDetectorFactoryCreators(array $detectorFactoryCreators): void
    {
        $this->detectorFactoryCreators = $detectorFactoryCreators;
    }

    public function addDetectorFactoryCreators(string $detectorFactoryCreator): void
    {
        $this->detectorFactoryCreators[] = $detectorFactoryCreator;
    }
}
