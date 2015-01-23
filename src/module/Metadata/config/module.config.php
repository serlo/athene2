<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL]
 */
namespace Metadata;

return [
    'class_resolver'  => [
        __NAMESPACE__ . '\Entity\MetadataInterface'    => __NAMESPACE__ . '\Entity\Metadata',
        __NAMESPACE__ . '\Entity\MetadataKeyInterface' => __NAMESPACE__ . '\Entity\MetadataKey'
    ],
    'view_helpers'    => [
        'factories' => [
            'metadata' => __NAMESPACE__ . '\Factory\MetadataHelperFactory'
        ],
    ],
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Manager\MetadataManager' => __NAMESPACE__ . '\Factory\MetadataManagerFactory'
        ]
    ],
    'di'              => [
        'definition' => [
            'class' => [
                __NAMESPACE__ . '\Listener\TaxonomyManagerListener' => [
                    'setMetadataManager' => [
                        'required' => true
                    ]
                ]
            ]
        ],
        'instance'   => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\MetadataManagerInterface' => __NAMESPACE__ . '\Manager\MetadataManager'
            ]
        ]
    ],
    'doctrine'        => [
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
    ]
];
