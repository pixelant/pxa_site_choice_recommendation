<?php
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
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, max_items, show_splash_page, splash_page_link, choices',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, root_pages, max_items, show_splash_page, splash_page_link, --div--;LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tab.choices, choices, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
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
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
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
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
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
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
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
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
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
        'show_splash_page' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.show_splash_page',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'splash_page_link' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.splash_page_link',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'renderType' => 'inputLink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'file,folder,mail'
                        ]
                    ]
                ]
            ],
        ],
        'root_pages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_sitechoice.root_pages',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'pages',
                'foreign_table_where' => 'pages.hidden=0 AND pages.deleted=0 AND pages.is_siteroot=1',
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
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],

    ],
];
