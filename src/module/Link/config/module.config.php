<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL]
 */
namespace Link;

return [
    'di'       => [
        'definition' => [
            'class' => [
                __NAMESPACE__ . '\Listener\EntityManagerListener' => [
                    'setLinkService'   => [
                        'required' => true
                    ],
                    'setEntityManager' => [
                        'required' => true
                    ],
                    'setModuleOptions' => [
                        'required' => true
                    ],
                ],
                __NAMESPACE__ . '\Service\LinkService'            => [
                    'setObjectManager'        => [
                        'required' => true
                    ],
                    'setTypeManager'          => [
                        'required' => true
                    ],
                    'setAuthorizationService' => [
                        'required' => true
                    ],
                ]
            ]
        ],
        'instance'   => [
            'preferences' => [
                'Link\Service\LinkServiceInterface' => 'Link\Service\LinkService'
            ]
        ]
    ],
    'doctrine' => [
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
