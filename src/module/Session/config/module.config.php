<?php
namespace Session;

return [
    'service_manager' => [
        'factories' => [
            'Zend\Session\SaveHandler\SaveHandlerInterface' => __NAMESPACE__ . '\Factory\SaveHandlerFactory'
        ]
    ],
    'controllers'      => [
        'factories' => [
            'Session\Controller\SessionController' => __NAMESPACE__ . '\Factory\SessionControllerFactory'
        ]
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'session' => [
                    'options' => [
                        'route'    => 'session gc',
                        'defaults' => [
                            'controller' => 'Session\Controller\SessionController',
                            'action'     => 'gc'
                        ]
                    ]
                ],
            ]
        ],
    ],
];
