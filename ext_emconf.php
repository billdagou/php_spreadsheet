<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'PhpSpreadsheet',
    'description' => 'PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet',
    'category' => 'fe',
    'author' => 'Bill.Dagou',
    'author_email' => 'billdagou@gmail.com',
    'version' => '1.20.0',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'dagou_fluid' => '10.4.0-10.4.99',
            'typo3' => '10.4.0-10.4.99',
        ],
    ],
    'autoload' => [
        'classmap' => [
            'Resources/Private/PhpSpreadsheet',
        ],
    ],
];