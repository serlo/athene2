<?php
/**
 * @author    Benjamin Knorr (benjamin@serlo.org]
 * @copyright 2017 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL]
 */
namespace StaticPage;

return [
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\StaticPageController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\StaticPageController' => []
            ]
        ]
    ],
    'router'          => [
        'routes' => [
            'spenden' => [
                'type'          => 'literal',
                'options'       => [
                    'route'    => '/spenden',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\StaticPageController',
                        'action'     => 'spenden'
                    ]
                ],
                'may_terminate' => true
            ],
        ]
    ]
];
