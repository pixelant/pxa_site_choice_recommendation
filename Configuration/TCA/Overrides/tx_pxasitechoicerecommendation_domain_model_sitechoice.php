<?php
defined('TYPO3_MODE') || die('Access denied.');

(function () {
    if (version_compare(TYPO3_version, '9.0', '>')) {
        $columns = &$GLOBALS['TCA']['tx_pxasitechoicerecommendation_domain_model_sitechoice']['columns'];

        $columns['root_pages']['config']['foreign_table_where'] .= ' AND pages.sys_language_uid=0';
    }
})();
