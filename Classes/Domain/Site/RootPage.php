<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Domain\Site;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class RootPage
 * @package Pixelant\PxaSiteChoiceRecommendation\Domain\Site
 */
class RootPage
{
    protected $tsfe = null;

    /**
     * Root page array
     *
     * @var array
     */
    protected $rootPage = null;

    /**
     * Initialize
     *
     * @param TypoScriptFrontendController|null $typoScriptFrontendController
     */
    public function __construct(TypoScriptFrontendController $typoScriptFrontendController = null)
    {
        $this->tsfe = $typoScriptFrontendController ?? $GLOBALS['TSFE'];
    }

    /**
     * Get root page record
     *
     * @return array
     */
    public function getRootPage(): ?array
    {
        if ($this->rootPage === null) {
            $this->determinateRootPage();
        }
        return $this->rootPage;
    }

    /**
     * Get root page
     *
     * @return int|null Uid of root page or 0 if not found
     */
    public function getRootPageUid(): int
    {
        $rootPage = $this->getRootPage();

        if (is_array($rootPage)) {
            return (int)$rootPage['uid'];
        }

        return 0;
    }

    /**
     * Get root page from root line
     */
    protected function determinateRootPage(): void
    {
        foreach ($this->tsfe->rootLine as $item) {
            if ($this->isSiteRoot($item)) {
                $this->rootPage = $item;
                return;
            }
        }
    }

    /**
     * Check if given page is site root
     *
     * @param array $page
     * @return bool
     */
    protected function isSiteRoot(array $page): bool
    {
        return intval($page['is_siteroot']) === 1;
    }
}
