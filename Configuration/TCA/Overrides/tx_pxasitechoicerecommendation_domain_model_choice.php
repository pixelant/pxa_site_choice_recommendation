<?php

defined('TYPO3_MODE') || die('Access denied.');

(function () {
    // Copy flags configuration from sys_language
    $flagConfig = &$GLOBALS['TCA']['tx_pxasitechoicerecommendation_domain_model_choice']['columns']['flag']['config'];
    $flagConfig = $GLOBALS['TCA']['sys_language']['columns']['flag']['config'];
})();
