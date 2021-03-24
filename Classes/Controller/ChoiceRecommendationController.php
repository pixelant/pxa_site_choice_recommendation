<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Controller;

use Psr\EventDispatcher\EventDispatcherInterface;
use Pixelant\PxaSiteChoiceRecommendation\Detector\Event\AddDetectorFactoryEvent;
use Pixelant\PxaSiteChoiceRecommendation\Domain\DTO\Bar\ChoiceBarFactory;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Repository\SiteChoiceRepository;
use Pixelant\PxaSiteChoiceRecommendation\Domain\Site\RootPage;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Page\PageRenderer;
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
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

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
     * @param EventDispatcher $eventDispatcher
     */
    public function injectDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher ?? GeneralUtility::makeInstance(EventDispatcher::class);
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

        // If there is what to show
        if ($siteChoice !== null && $siteChoice->getChoices()->count() > 0) {
            $choiceBarFactory = GeneralUtility::makeInstance(ChoiceBarFactory::class);
            $choiceBar = $choiceBarFactory->build($siteChoice, $this->getAvailableDetectorFactoryCreators());

            $this->view->assign('choiceBar', $choiceBar);

            if ($choiceBar->isVisible()) {
                $response = [
                    'visible' => true,
                    'settings' => $this->settings['jsBar'] ?? [],
                    'html' => $this->view->render()
                ];
            }
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
     */
    protected function getAvailableDetectorFactoryCreators()
    {
        $event = new AddDetectorFactoryEvent();
        $this->eventDispatcher->dispatch($event);
        $detectorFactoryCreators = $event->getDetectorFactoryCreators();

        return $detectorFactoryCreators;
    }

    /**
     * Add JS variable that make bar invisible
     */
    protected function disableBarOnCurrentPage(): void
    {
        // User header data in order to make sure it's on top of page
        GeneralUtility::makeInstance(PageRenderer::class)->addHeaderData(
            '<script>const force_hide_site_choice_recommendation=1;</script>'
        );
    }
}
