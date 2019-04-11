<?php

defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'pxa_site_choice_recommendation',
    'Splash',
    'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_be.xlf:plugin.splash'
);

(function () {
    $plugin = 'pxasitechoicerecommendation_splash';

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$plugin] = 'recursive,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$plugin] = 'pi_flexform';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        $plugin,
        'FILE:EXT:pxa_site_choice_recommendation/Configuration/FlexForms/flexform_choice.xml'
    );
})();
