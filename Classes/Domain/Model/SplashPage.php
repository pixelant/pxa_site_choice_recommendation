<?php
declare(strict_types=1);


namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;

/**
 * Class SplashPage
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\Model
 */
class SplashPage extends AbstractDomainObject
{
    /**
     * @var int
     */
    protected $rootPage = 0;

    /**
     * @var string
     */
    protected $linkTarget = '';

    /**
     * @return int
     */
    public function getRootPage(): int
    {
        return $this->rootPage;
    }

    /**
     * @param int $rootPage
     */
    public function setRootPage(int $rootPage): void
    {
        $this->rootPage = $rootPage;
    }

    /**
     * @return string
     */
    public function getLinkTarget(): string
    {
        return $this->linkTarget;
    }

    /**
     * @param string $linkTarget
     */
    public function setLinkTarget(string $linkTarget): void
    {
        $this->linkTarget = $linkTarget;
    }
}
