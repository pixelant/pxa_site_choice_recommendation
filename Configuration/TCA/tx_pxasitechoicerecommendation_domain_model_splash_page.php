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
            'title' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_splash_page',
            'label' => 'root_page',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'cruser_id' => 'cruser_id',
            'languageField' => 'sys_language_uid',
            'transOrigPointerField' => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
            'delete' => 'deleted',
            'enablecolumns' => [
                'disabled' => 'hidden',
            ],
            'searchFields' => 'root_page,link_target',
            'iconfile' => 'EXT:pxa_site_choice_recommendation/Resources/Public/Icons/link.svg'
        ],
        'interface' => [
            'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, root_page, link_target',
        ],
        'types' => [
            '1' => ['showitem' => '--palette--;;topRowPalette, root_page, link_target'],
        ],
        'palettes' => [
            'topRowPalette' => [
                'showitem' => 'sitechoice, sys_language_uid, l10n_parent, l10n_diffsource,'
            ],
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
                    'foreign_table' => 'tx_pxasitechoicerecommendation_domain_model_choice',
                    'foreign_table_where' => 'AND {#tx_pxasitechoicerecommendation_domain_model_choice}.{#pid}=###CURRENT_PID### AND {#tx_pxasitechoicerecommendation_domain_model_choice}.{#sys_language_uid} IN (-1,0)',
                ],
            ],
            'l10n_diffsource' => [
                'config' => [
                    'type' => 'passthrough',
                ],
            ],
            'hidden' => $hidden,

            'root_page' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_splash_page.root_page',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'minitems' => 1,
                    'foreign_table' => 'pages',
                    'foreign_table_where' => 'pages.hidden=0 AND pages.deleted=0 AND pages.is_siteroot=1' . $appendRootPageWhere,
                ]
            ],

            'link_target' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_splash_page.link_target',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'renderType' => 'inputLink',
                    'eval' => 'required,trim',
                    'fieldControl' => [
                        'linkPopup' => [
                            'options' => [
                                'blindLinkOptions' => 'file,folder,mail'
                            ]
                        ]
                    ]
                ],
            ],

            'sitechoice' => [
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.sitechoice',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'foreign_table' => 'tx_pxasitechoicerecommendation_domain_model_sitechoice',
                    'foreign_table_where' => 'AND tx_pxasitechoicerecommendation_domain_model_sitechoice.deleted=0',
                    'items' => [
                        ['LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.none', 0],
                    ]
                ]
            ],
        ],
    ];
})();
