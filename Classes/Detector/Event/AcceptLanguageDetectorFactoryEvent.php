<?php

declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Detector\Event;

use Pixelant\PxaSiteChoiceRecommendation\Detector\Event\AddDetectorFactoryEvent;
use Pixelant\PxaSiteChoiceRecommendation\Detector\Factory\AcceptLanguageDetectorFactory;

/**
 * Adds AcceptLanguageDetector to Detectors.
 */
final class AcceptLanguageDetectorFactoryEvent
{
    public function __invoke(AddDetectorFactoryEvent $event)
    {
        $event->addDetectorFactoryCreators(AcceptLanguageDetectorFactory::class);
    }
}
