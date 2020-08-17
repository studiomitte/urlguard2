<?php

return [
    'frontend' => [
        'typo3/cms-urlguard2/remove-l-params' => [
            'target' => \StudioMitte\Urlguard2\Middleware\RemoveLParams::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
            ]
        ],
    ]
];
