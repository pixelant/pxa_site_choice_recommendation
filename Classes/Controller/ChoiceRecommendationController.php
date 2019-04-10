<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Controller;

use Pixelant\PxaSiteChoiceRecommendation\Domain\Repository\SiteChoiceRepository;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Site\RootPage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class ChoiceRecommendationController
 * @package Pixelant\PxaSiteRecommendation\Controller
 */
class ChoiceRecommendationController extends ActionController
{
    /**
     * @var SiteChoiceRepository
     */
    protected $siteChoiceRepository = null;

    /**
     * @var RootPage
     */
    protected $rootPage = null;

    /**
     * Inject repository
     *
     * @param SiteChoiceRepository $siteChoiceRepository
     */
    public function injectSiteChoiceRepository(SiteChoiceRepository $siteChoiceRepository): void
    {
        $this->siteChoiceRepository = $siteChoiceRepository;
    }

    /**
     * Inject
     *
     * @param RootPage $rootPage
     */
    public function injectRootPage(RootPage $rootPage): void
    {
        $this->rootPage = $rootPage;
    }

    /**
     * Create site choice recommendation bar
     *
     * @return string JSON response
     */
    public function recommendationBarAction()
    {
        $response = [
            'visible' => false
        ];

        $siteChoice = $this->siteChoiceRepository->findOneByRootPage(
            $this->rootPage->getRootPageUid()
        );

        if ($siteChoice !== null) {
            $visible = true;
            $settings = $this->settings['jsBar'] ?? [];
            $html = $this->view->render();
        }

        return json_encode($response);
    }
}
