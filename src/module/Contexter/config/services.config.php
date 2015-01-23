<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Contexter;

return [
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Router\Router'         => __NAMESPACE__ . '\Factory\RouterFactory',
            __NAMESPACE__ . '\Options\ModuleOptions' => __NAMESPACE__ . '\Factory\ModuleOptionsFactory'
        ]
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\ContextController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Adapter\EntityControllerAdapter' => [
                    'setInstanceManager' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Controller\ContextController'    => [],
                __NAMESPACE__ . '\Manager\ContextManager'          => []
            ]
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\ContextManagerInterface' => __NAMESPACE__ . '\Manager\ContextManager',
                __NAMESPACE__ . '\Router\RouterInterface'          => __NAMESPACE__ . '\Router\Router'
            ]
        ]
    ]
];
