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
    }

    return [
        'ctrl' => [
            'title' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice',
            'label' => 'title',
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
            'searchFields' => 'title,locale,link',
            'iconfile' => 'EXT:pxa_site_choice_recommendation/Resources/Public/Icons/Extension.svg'
        ],
        'interface' => [
            'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, flag, country_isocode, language_isocode, link, language_layer_uid',
        ],
        'types' => [
            '1' => ['showitem' =>
                '--palette--;;topRowPalette, title, flag,
             --palette--;LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.localePalette;localePalette,
             --palette--;LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.linkToPalette;linkToPalette,'
            ],
        ],
        'palettes' => [
            'topRowPalette' => [
                'showitem' => 'sitechoice, sys_language_uid, l10n_parent, l10n_diffsource,'
            ],
            'localePalette' => [
                'showitem' => 'country_isocode, language_isocode'
            ],
            'linkToPalette' => [
                'showitem' => 'link, language_layer_uid'
            ]
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

            'title' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.title',
                'config' => [
                    'type' => 'text',
                    'cols' => 30,
                    'rows' => 5,
                    'eval' => 'trim',
                ]
            ],
            'flag' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.flag',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [],
                ],
            ],
            'country_isocode' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.country_isocode',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.country_isocode.none', '']
                    ],
                    'itemsProcFunc' => \Pixelant\PxaSiteChoiceRecommendation\Service\TCA\SelectService::class . '->renderCountryIsoCodeSelectDropdown',
                ],
            ],
            'language_isocode' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.language_isocode',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.language_isocode.none', '']
                    ],
                    'itemsProcFunc' => \Pixelant\PxaSiteChoiceRecommendation\Service\TCA\SelectService::class . '->renderLanguageIsoCodeSelectDropdown',
                ],
            ],
            'link' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.link',
                'config' => [
                    'type' => 'input',
                    'size' => 20,
                    'eval' => 'trim',
                    'renderType' => 'inputLink',
                    'fieldControl' => [
                        'linkPopup' => [
                            'options' => [
                                'blindLinkOptions' => 'file,folder,mail',
                                'blindLinkFields' => 'class,target,title'
                            ]
                        ]
                    ]
                ],
            ],
            'language_layer_uid' => [
                'exclude' => true,
                'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.language_layer_uid',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'foreign_table' => 'sys_language',
                    'foreign_table_where' => 'ORDER BY sys_language.sorting',
                    'items' => [
                        ['LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.none', 0],
                    ]
                ]
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
