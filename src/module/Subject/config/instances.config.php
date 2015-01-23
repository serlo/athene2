<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
return [
    'subject' => [
        'instances' => [
            'deutsch' => [
                'mathe'                    => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ],
                'englisch'                 => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ],
                'betriebswirtschaftslehre mit rechnungswesen' => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ],
                'deutsch als fremdsprache'                    => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ],
                'chemie'                   => [
                    'allowed_taxonomies' => [
                        'topic'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'text-exercise-group'
                    ]
                ],
                'permakultur'              => [
                    'allowed_taxonomies' => [
                        'topic'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'video',
                        'course',
                        'text-exercise',
                        'text-exercise-group'
                    ]
                ],
                'physik'                   => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ],
                'biologie'                 => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ]
            ],
            'english' => [
                'math' => [
                    'allowed_taxonomies' => [
                        'topic',
                        'locale'
                    ],
                    'allowed_entities'   => [
                        'article',
                        'text-exercise',
                        'video',
                        'course',
                        'text-exercise-group'
                    ]
                ]
            ]
        ]
    ]
];