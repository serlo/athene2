<?php
/**
 * Global Configuration Override
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 *      control, so do not include passwords or other sensitive information in this
 *      file.
 */

return [
    'zfctwig'         => [
        'environment_options' => [
            'cache' => __DIR__ . '/../../data/twig'
        ],
        'extensions' => [
            'Twig_Extensions_Extension_I18n',
        ]
    ],
    'doctrine'        => [
        'entitymanager' => [
            'orm_default' => [
                'connection'    => 'orm_default',
                'configuration' => 'orm_default',
            ]
        ]
    ],
    'router'          => [
        'router_class' => 'Zend\Mvc\Router\Http\TranslatorAwareTreeRouteStack'
    ],
    'session'         => [
        'config'     => [
            'class'   => 'Zend\Session\Config\SessionConfig',
            'options' => [
                'name'                => 'athene2',
                'cookie_lifetime'     => 2419200,
                'remember_me_seconds' => 2419200,
                'use_cookies'         => true,
                'cookie_secure'       => false
            ]
        ],
        'storage'    => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => [
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent'
        ],
    ],
    'di'              => [
        'instance' => [
            'preferences' => [
                'Zend\ServiceManager\ServiceLocatorInterface' => 'ServiceManager',
                'Doctrine\Common\Persistence\ObjectManager'   => 'Doctrine\ORM\EntityManager'
            ]
        ]
    ],
    'sphinx'          => [
        'host' => '127.0.0.1',
        'port' => 9306
    ],
    'zendDiCompiler'  => [],
    'zfc_rbac'        => [
        'redirect_strategy' => [
            'redirect_to_route_connected'    => 'authorization/forbidden',
            'redirect_to_route_disconnected' => 'authentication/login',
            'append_previous_uri'            => true,
            'previous_uri_query_key'         => 'redir'
        ]
    ]
];
