<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Controller;

use Pixelant\PxaSiteChoiceRecommendation\Detector\Factory\AcceptLanguageDetectorFactory;
use Pixelant\PxaSiteChoiceRecommendation\Detector\Factory\IpDetectorFactory;
use Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar\ChoiceBarFactory;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Repository\SiteChoiceRepository;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Site\RootPage;
use Pixelant\PxaSiteChoiceRecommendation\SignalSlot\DispatcherTrait;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class ChoiceRecommendationController
 * @package Pixelant\PxaSiteRecommendation\Controller
 */
class ChoiceRecommendationController extends ActionController
{
    use DispatcherTrait;

    /**
     * @var SiteChoiceRepository
     */
    protected $siteChoiceRepository = null;

    /**
     * @var RootPage
     */
    protected $rootPage = null;

    /**
     * Available language detectors creators
     *
     * @var array
     */
    protected $detectorFactoryCreators = [
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
            $choiceBar = $choiceBarFactory->build($siteChoice, $this->getAvailableDetectorFactoryCreators());

            $this->view->assign('choiceBar', $choiceBar);

            $response = [
                'visible' => $choiceBar->isVisible(),
                'settings' => $this->settings['jsBar'] ?? [],
                'html' => $this->view->render()
            ];
        }

        return json_encode($response);
    }

    /**
     * Splash page action
     */
    public function splashPageAction()
    {
        list($siteChoiceUid) = array_reverse(
            GeneralUtility::trimExplode('_', $this->settings['siteChoice'] ?? '')
        );
        $siteChoice = $this->siteChoiceRepository->findByUid((int)$siteChoiceUid);

        if (intval($this->settings['showBarOnSplashPage'] ?? 0) === 0) {
            $this->disableBarOnCurrentPage();
        }
        $this->view->assign('siteChoice', $siteChoice);
    }

    /**
     * Return array of factory creators of availble locale and country ISO code detectors
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    protected function getAvailableDetectorFactoryCreators()
    {
        $detectorFactoryCreators = $this->detectorFactoryCreators;

        $signalArguments = [
            'detectorFactoryCreators' => &$detectorFactoryCreators
        ];

        $this->emitSignal(__CLASS__, 'beforeReturningAvailableDetectorFactoryCreators', $signalArguments);

        return $detectorFactoryCreators;
    }

    protected function disableBarOnCurrentPage(): void
    {
        GeneralUtility::makeInstance(PageRenderer::class)->addHeaderData(
            '<script>const force_hide_site_choice_recommendation=1;</script>'
        );
    }
}
