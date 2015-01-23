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
    'zfc_rbac'               => [
        'assertion_map' => [
            'contexter.context.add'    => 'Authorization\Assertion\RequestInstanceAssertion',
            'contexter.context.remove' => 'Authorization\Assertion\InstanceAssertion',
            'contexter.context.manage' => 'Authorization\Assertion\InstanceAssertion',
            'contexter.context.get'    => 'Authorization\Assertion\InstanceAssertion',
            'contexter.route.add'      => 'Authorization\Assertion\InstanceAssertion',
            'contexter.route.get'      => 'Authorization\Assertion\InstanceAssertion',
            'contexter.route.remove'   => 'Authorization\Assertion\InstanceAssertion',
        ]
    ],
    'Manager\ContextManager' => [
        'router' => [
            'adapters' => [
                [
                    'adapter'     => __NAMESPACE__ . '\Adapter\EntityControllerAdapter',
                    'controllers' => [
                        [
                            'controller' => 'Entity\Controller\RepositoryController',
                            'action'     => 'addRevision'
                        ],
                        [
                            'controller' => 'Entity\Controller\RepositoryController',
                            'action'     => 'history'
                        ],
                        [
                            'controller' => 'Entity\Controller\RepositoryController',
                            'action'     => 'compare'
                        ],
                        [
                            'controller' => 'Entity\Controller\TaxonomyController',
                            'action'     => 'update'
                        ],
                        [
                            'controller' => 'Entity\Controller\PageController',
                            'action'     => 'index'
                        ]
                    ]
                ],
                [
                    'adapter'     => __NAMESPACE__ . '\Adapter\RelatedContentControllerAdapter',
                    'controllers' => [
                        [
                            'controller' => 'RelatedContent\Controller\RelatedContentController',
                            'action'     => 'manage'
                        ],
                        [
                            'controller' => 'RelatedContent\Controller\RelatedContentController',
                            'action'     => 'addInternal'
                        ],
                        [
                            'controller' => 'RelatedContent\Controller\RelatedContentController',
                            'action'     => 'addExternal'
                        ],
                        [
                            'controller' => 'RelatedContent\Controller\RelatedContentController',
                            'action'     => 'addCategory'
                        ],
                    ]
                ],
                [
                    'adapter'     => __NAMESPACE__ . '\Adapter\TaxonomyTermControllerAdapter',
                    'controllers' => [
                        [
                            'controller' => 'Taxonomy\Controller\TermController',
                            'action'     => 'organize'
                        ],
                        [
                            'controller' => 'Taxonomy\Controller\TermController',
                            'action'     => 'orderAssociated'
                        ],
                        [
                            'controller' => 'Taxonomy\Controller\GetController',
                            'action'     => 'index'
                        ]
                    ]
                ],
                [
                    'adapter'     => __NAMESPACE__ . '\Adapter\SubjectControllerAdapter',
                    'controllers' => [
                        [
                            'controller' => 'Subject\Controller\EntityController',
                            'action'     => 'unrevised'
                        ],
                    ]
                ]
            ]
        ]
    ],
    'contexter'              => [
        'types' => [
            'help',
            'guideline'
        ]
    ],
    'view_helpers'           => [
        'factories' => [
            'contexter' => __NAMESPACE__ . '\Factory\ContexterHelperFactory'
        ]
    ],
    'class_resolver'         => [
        'Contexter\Entity\ContextInterface'        => 'Contexter\Entity\Context',
        'Contexter\Entity\TypeInterface'           => 'Contexter\Entity\Type',
        'Contexter\Entity\RouteInterface'          => 'Contexter\Entity\Route',
        'Contexter\Entity\RouteParameterInterface' => 'Contexter\Entity\RouteParameter'
    ],
    'doctrine'               => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ]
            ],
            'orm_default'             => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
