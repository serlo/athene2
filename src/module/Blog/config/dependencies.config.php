<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Blog;

return [
    'alias_manager' => [
        'aliases' => [
            'blogPost' => [
                'tokenize' => 'blog/{blog}/{title}',
                'provider' => 'Blog\Provider\TokenizerProvider',
                'fallback' => 'blog/{blog}/{title}-{id}'
            ]
        ]
    ],
    'taxonomy'      => [
        'types' => [
            'blog' => [
                'allowed_associations' => [
                    'Blog\Entity\PostInterface'
                ],
                'allowed_parents'      => [
                    'root'
                ],
                'rootable'             => false
            ]
        ]
    ]
];
