<?php
defined('TYPO3_MODE') || die('Access denied.');

return (function () {
    if (version_compare(TYPO3_version, '9.0', '>')) {
        $llCore = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
        $hidden = [
            'exclude' => true,
            'label' => $llCore . 'LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ];
        $appendRootPageWhere = ' AND pages.sys_language_uid=0';
    } else {
        $llCore = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:';
        $hidden = [
            'exclude' => true,
            'label' => $llCore . 'LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ];
        $appendRootPageWhere = '';
    }

    return [
        'ctrl' => [
            'title' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice',
            'label' => 'name',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'cruser_id' => 'cruser_id',
            'languageField' => 'sys_language_uid',
            'transOrigPointerField' => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
            'delete' => 'deleted',
            'enablecolumns' => [
                'disabled' => 'hidden',
                'starttime' => 'starttime',
                'endtime' => 'endtime',
            ],
            'searchFields' => 'name,splash_page_link',
            'iconfile' => 'EXT:pxa_site_choice_recommendation/Resources/Public/Icons/Extension.svg'
        ],
        'interface' => [
            'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, max_items, choices, splash_pages',
        ],
        'types' => [
            '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, root_pages, max_items, splash_pages, --div--;LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tab.choices, choices, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
        ],
        'columns' => [
            'sys_language_uid' => [
                'exclude' => true,
                'label' => $llCore . 'LGL.language',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'special' => 'languages',
                    'items' => [
                        [
                            $llCore . 'LGL.allLanguages',
                            -1,
                            'flags-multiple'
                        ]
                    ],
                    'default' => 0,
                ],
            ],
            'l10n_parent' => [
                'displayCond' => 'FIELD:sys_language_uid:>:0',
                'exclude' => true,
                'label' => $llCore . 'LGL.l18n_parent',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'default' => 0,
                    'items' => [
                        ['', 0],
                    ],
                    'foreign_table' => 'tx_pxasitechoicerecommendation_domain_model_sitechoice',
                    'foreign_table_where' => 'AND {#tx_pxasitechoicerecommendation_domain_model_sitechoice}.{#pid}=###CURRENT_PID### AND {#tx_pxasitechoicerecommendation_domain_model_sitechoice}.{#sys_language_uid} IN (-1,0)',
                ],
            ],
            'l10n_diffsource' => [
                'config' => [
                    'type' => 'passthrough',
                ],
            ],
            'hidden' => $hidden,
            'starttime' => [
                'exclude' => true,
                'label' => $llCore . 'LGL.starttime',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputDateTime',
                    'eval' => 'datetime,int',
                    'default' => 0,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ],
            ],
            'endtime' => [
                'exclude' => true,
                'label' => $llCore . 'LGL.endtime',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputDateTime',
                    'eval' => 'datetime,int',
                    'default' => 0,
                    'range' => [
                        'upper' => mktime(0, 0, 0, 1, 1, 2038)
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ],
            ],

            'name' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.name',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim,required'
                ],
            ],
            'max_items' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.max_items',
                'config' => [
                    'type' => 'input',
                    'size' => 4,
                    'eval' => 'int'
                ]
            ],
            'splash_pages' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.splash_pages',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_pxasitechoicerecommendation_domain_model_splash_page',
                    'foreign_field' => 'sitechoice',
                    'foreign_sortby' => 'sorting',
                    'maxitems' => 9999,
                    'appearance' => [
                        'collapseAll' => true,
                        'levelLinksPosition' => 'top',
                        'showSynchronizationLink' => true,
                        'showPossibleLocalizationRecords' => true,
                        'showAllLocalizationLink' => true
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'root_pages' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.root_pages',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'foreign_table' => 'pages',
                    'foreign_table_where' => 'pages.hidden=0 AND pages.deleted=0 AND pages.is_siteroot=1' . $appendRootPageWhere,
                ]
            ],
            'choices' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.choices',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_pxasitechoicerecommendation_domain_model_choice',
                    'foreign_field' => 'sitechoice',
                    'foreign_sortby' => 'sorting',
                    'maxitems' => 9999,
                    'appearance' => [
                        'collapseAll' => true,
                        'levelLinksPosition' => 'top',
                        'showSynchronizationLink' => true,
                        'showPossibleLocalizationRecords' => true,
                        'showAllLocalizationLink' => true
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],

            ],

        ],
    ];
})();
