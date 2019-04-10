<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Controller;

use Pixelant\PxaSiteChoiceRecommendation\Detector\Factory\AcceptLanguageDetectorFactory;
use Pixelant\PxaSiteChoiceRecommendation\Detector\Factory\IpDetectorFactory;
use Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar\ChoiceBar;
use Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar\ChoiceBarFactory;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Repository\SiteChoiceRepository;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Site\RootPage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
     * Available detectors creators
     *
     * @var array
     */
    protected $detectorCreators = [
        IpDetectorFactory::class,
        AcceptLanguageDetectorFactory::class
    ];

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
            $choiceBarFactory = GeneralUtility::makeInstance(ChoiceBarFactory::class);
            $choiceBar = $choiceBarFactory->build($siteChoice, $this->detectorCreators);

            $this->view->assign('choiceBar', $choiceBar);

            $response['visible'] = true;
            $response['settings'] = $this->settings['jsBar'] ?? [];
            $response['html'] = $this->view->render();
        }

        return json_encode($response);
    }
}
