<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'pxa_site_choice_recommendation',
    'Configuration/TypoScript/Default',
    'Site choice recommendation'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'pxa_site_choice_recommendation',
    'Configuration/TypoScript/JsAndCss',
    'Site choice JS and CSS assets'
);
