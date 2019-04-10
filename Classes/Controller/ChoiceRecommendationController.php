<?php
declare(strict_types=1);

namespace Pixelant\PxaSiteChoiceRecommendation\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class ChoiceRecommendationController
 * @package Pixelant\PxaSiteRecommendation\Controller
 */
class ChoiceRecommendationController extends ActionController
{
    /**
     * Create site choice recommendation bar
     *
     * @return string JSON response
     */
    public function recommendationBarAction()
    {
        $visible = true;
        $settings = $this->settings['jsBar'] ?? [];
        $html = $this->view->render();

        return json_encode(compact('visible', 'settings', 'html'));
    }
}
