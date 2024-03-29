<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Remove unwanted params from addquerystring',
    'description' => 'Just keep all parameters which have been mapped in the routing configuration',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'gr@studiomitte.com',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '1.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-11.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
