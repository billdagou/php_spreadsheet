<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'PhpSpreadsheet',
    'description' => 'PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet',
    'version' => '1.25.2',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
        'suggests' => [
            'dagou_fluid' => '',
        ],
    ],
    'state' => 'stable',
    'author' => 'Bill.Dagou',
    'author_email' => 'billdagou@gmail.com',
    'autoload' => [
        'classmap' => [
            'Classes',
            'Resources/Private/PhpSpreadsheet',
        ],
    ],
];