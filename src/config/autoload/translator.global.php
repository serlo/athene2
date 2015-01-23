<?php
return [
    'translator' => [
        'locale'                    => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../../lang',
                'pattern'  => '%s/LC_MESSAGES/athene2.mo'
            ]
        ]
    ]
];