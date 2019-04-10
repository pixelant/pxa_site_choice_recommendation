<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        $tables = [
            'tx_pxasitechoicerecommendation_domain_model_sitechoice',
            'tx_pxasitechoicerecommendation_domain_model_choice'
        ];
        foreach ($tables as $table) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
                $table,
                'EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_csh_' . $table . '.xlf'
            );
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages($table);
        }
    }
);
