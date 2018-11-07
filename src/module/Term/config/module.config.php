<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Term;

/**
 * @codeCoverageIgnore
 */
return [
    'class_resolver' => [
        'Term\Entity\TermEntityInterface' => 'Term\Entity\TermEntity',
    ],
    'di'             => [
        'definition' => [
            'class' => [
                'Term\Manager\TermManager' => [
                    'setObjectManager'   => [
                        'required' => true,
                    ],
                    'setServiceLocator'  => [
                        'required' => true,
                    ],
                    'setInstanceManager' => [
                        'required' => true,
                    ],
                    'setClassResolver'   => [
                        'required' => true,
                    ],
                ],
            ],
        ],
        'instance'   => [
            'preferences' => [
                'Term\Manager\TermManagerInterface' => 'Term\Manager\TermManager',
            ],
        ],
    ],
    'doctrine'       => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ],
            ],
            'orm_default'             => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];
