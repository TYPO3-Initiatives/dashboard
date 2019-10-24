<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'demo',
    'description' => 'demo fixture extension',
    'category' => 'fe',
    'author' => 'Kasper',
    'author_email' => 'kasper@example.com',
    'author_company' => '',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0 - 10.4.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
