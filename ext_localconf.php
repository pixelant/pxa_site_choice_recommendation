<?php
defined('TYPO3_MODE') || die('Access denied.');

(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Pixelant.pxa_site_choice_recommendation',
        'Choice',
        [
            'ChoiceRecommendation' => 'recommendationBar'
        ],
        [
            'ChoiceRecommendation' => 'recommendationBar'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Pixelant.pxa_site_choice_recommendation',
        'Splash',
        [
            'ChoiceRecommendation' => 'splashPage'
        ]
    );
})();
