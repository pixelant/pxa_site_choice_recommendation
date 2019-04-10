<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Model\SiteChoice;

/**
 * Class BarFactoryInterface
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar
 */
interface BarFactoryInterface
{
    /**
     * Build bar
     *
     * @param SiteChoice $siteChoice Site choice record
     * @param array $detectorCreatorsClassNames Available detectors factories
     * @return BarInterface
     */
    public function build(SiteChoice $siteChoice, array $detectorCreatorsClassNames): BarInterface;
}
