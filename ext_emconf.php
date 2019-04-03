<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Site choice recommendation',
    'description' => 'Suggest localized version of site depends on user location and user language.',
    'category' => 'fe',
    'author' => 'Pixelant',
    'author_email' => 'info@pixelant.net',
    'author_company' => 'Pixelant',
    'state' => 'alpha',
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
