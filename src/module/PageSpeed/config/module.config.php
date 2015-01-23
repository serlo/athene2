<?php
namespace PageSpeed;

return [
    'console' => [
        'router' => [
            'routes' => [
                'pagespeed' => [
                    'options' => [
                        'route'    => 'pagespeed build',
                        'defaults' => [
                            'controller' => 'PageSpeed\Controller\PageSpeedController',
                            'action'     => 'build'
                        ]
                    ]
                ],
            ]
        ],
    ],
    'di'      => [
        'allowed_controllers' => [
            'PageSpeed\Controller\PageSpeedController'
        ],
        'definition'          => [
            'class' => [
                'PageSpeed\Controller\PageSpeedController' => []
            ]
        ],
    ]
];
