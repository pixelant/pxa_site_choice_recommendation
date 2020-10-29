<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Site choice recommendation',
    'description' => 'Suggest localized version of site depends on user location and user language.',
    'category' => 'fe',
    'author' => 'Pixelant',
    'author_email' => 'info@pixelant.net',
    'author_company' => 'Pixelant',
    'state' => 'stable',
    'version' => '1.0.3',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-10.4.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
