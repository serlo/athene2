<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Blog;

return [
    'zendDiCompiler' => [
        'scanDirectories' => [
            __DIR__ . '/../src',
        ],
    ],
    'zfc_rbac'       => [
        'assertion_map' => [
            'blog.get'                   => 'Authorization\Assertion\InstanceAssertion',
            'blog.post.create'           => 'Authorization\Assertion\InstanceAssertion',
            'blog.post.get'              => 'Authorization\Assertion\InstanceAssertion',
            'blog.post.update'           => 'Authorization\Assertion\InstanceAssertion',
            'blog.post.trash'            => 'Authorization\Assertion\InstanceAssertion',
            'blog.post.delete'           => 'Authorization\Assertion\InstanceAssertion',
            'blog.posts.get.unpublished' => 'Authorization\Assertion\InstanceAssertion',
            'blog.posts.get'             => 'Authorization\Assertion\InstanceAssertion',
        ],
    ],
    'uuid'           => [
        'permissions' => [
            'Blog\Entity\Post' => [
                'trash'   => 'blog.post.trash',
                'restore' => 'blog.post.restore',
                'purge'   => 'blog.post.purge',
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
    'di'             => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\BlogController',
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Form\CreatePostForm'       => [],
                __NAMESPACE__ . '\Form\UpdatePostForm'       => [],
                __NAMESPACE__ . '\Controller\BlogController' => [],
                __NAMESPACE__ . '\Manager\BlogManager'       => [
                    'setTaxonomyManager'      => [
                        'required' => true,
                    ],
                    'setClassResolver'        => [
                        'required' => true,
                    ],
                    'setObjectManager'        => [
                        'required' => true,
                    ],
                    'setUuidManager'          => [
                        'required' => true,
                    ],
                    'setInstanceManager'      => [
                        'required' => true,
                    ],
                    'setAuthorizationService' => [
                        'required' => true,
                    ],
                ],
            ],
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\BlogManagerInterface' => __NAMESPACE__ . '\Manager\BlogManager',
            ],
        ],
    ],
    'class_resolver' => [
        __NAMESPACE__ . '\Entity\PostInterface'         => __NAMESPACE__ . '\Entity\Post',
        __NAMESPACE__ . '\Service\PostServiceInterface' => __NAMESPACE__ . '\Service\PostService',
        __NAMESPACE__ . '\Manager\PostManagerInterface' => __NAMESPACE__ . '\Manager\PostManager',
    ],
];
