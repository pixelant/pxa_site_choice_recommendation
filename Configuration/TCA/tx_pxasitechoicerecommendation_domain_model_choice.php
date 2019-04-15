<?php
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
        'hideTable' => true,
        'searchFields' => 'title,locale,link',
        'iconfile' => 'EXT:pxa_site_choice_recommendation/Resources/Public/Icons/Extension.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, locale, language_uid, link, language_layer_uid',
    ],
    'types' => [
        '1' => ['showitem' =>
            'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title,
             --palette--;LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.localePalette;localePalette,
             --palette--;LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.localePalette;linkToPalette,'
        ],
    ],
    'palettes' => [
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
                'foreign_table' => 'tx_pxasitechoicerecommendation_domain_model_choice',
                'foreign_table_where' => 'AND {#tx_pxasitechoicerecommendation_domain_model_choice}.{#pid}=###CURRENT_PID### AND {#tx_pxasitechoicerecommendation_domain_model_choice}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
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
        'country_isocode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.country_isocode',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,required'
            ],
        ],
        'language_isocode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.language_isocode',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,required'
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
                            'blindLinkOptions' => 'page,file,folder,mail',
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
                    [ 'LLL:EXT:pxa_site_choice_recommendation/Resources/Private/Language/locallang_db.xlf:tx_pxasitechoicerecommendation_domain_model_choice.none', 0 ],
                ]
            ]
        ],

        'sitechoice' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
