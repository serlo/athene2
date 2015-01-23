<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL]
 */
namespace Versioning;

return [
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Options\ModuleOptions' => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\RepositoryManager'     => __NAMESPACE__ . '\Factory\RepositoryManagerFactory'
        ]
    ],
    'class_resolver'  => [
        'Versioning\Service\RepositoryServiceInterface' => 'Versioning\Service\RepositoryService'
    ],
    'di'              => [
        'definition' => [
            'class' => [
                'Versioning\Service\RepositoryService' => [
                    'setUuidManager'          => [
                        'required' => true
                    ],
                    'setObjectManager'        => [
                        'required' => true
                    ],
                    'setAuthorizationService' => [
                        'required' => true
                    ],
                    'setModuleOptions'        => [
                        'required' => true
                    ]
                ]
            ]
        ],
        'instance'   => [
            'preferences'                          => [
                'Versioning\RepositoryManagerInterface' => 'Versioning\RepositoryManager'
            ],
            'Versioning\Service\RepositoryService' => [
                'shared' => false
            ]
        ]
    ]
];
