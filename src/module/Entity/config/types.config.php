<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity;

return [
    'entity' => [
        'types' => [
            'math-puzzle' => [
                'title' => 'id',
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\MathPuzzleForm',
                        'fields' => [
                            'content',
                            'source',
                            'changes'
                        ]
                    ],
                    'license'    => [],
                    'taxonomy'   => []
                ]

            ],
            'text-exercise'         => [
                'title'       => 'id',
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\TextExerciseForm',
                        'fields' => [
                            'content',
                            'changes'
                        ]
                    ],
                    'link'       => [
                        'children' => [
                            'text-solution' => [
                                'multiple' => false
                            ],
                            'text-hint'     => [
                                'multiple' => false
                            ],
                            'text-input-solution' => [
                                'multiple' => true
                            ]
                        ]
                    ],
                    'license'    => [],
                    'taxonomy'   => []
                ]
            ],
            'text-input-solution' => [
                'title' => 'id',
                'description' => 'content',
                'components' => [
                    'repository' => [
                        // no form yet
                        'fields' => [
                            'content',
                            'validator'
                        ]
                    ]
                ]
            ],
            'text-exercise-group'   => [
                'title'       => 'id',
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\TextExerciseGroupForm',
                        'fields' => [
                            'content',
                            'changes'
                        ]
                    ],
                    'link'       => [
                        'children' => [
                            'grouped-text-exercise' => [
                                'multiple' => true
                            ]
                        ]
                    ],
                    'license'    => [],
                    'taxonomy'   => []
                ]
            ],
            'grouped-text-exercise' => [
                'title'       => 'id',
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\GroupedTextExerciseForm',
                        'fields' => [
                            'content',
                            'changes'
                        ]
                    ],
                    'link'       => [
                        'children' => [
                            'text-solution' => [
                                'multiple' => false
                            ],
                            'text-hint'     => [
                                'multiple' => false
                            ]
                        ],
                        'parents'  => [
                            'text-exercise-group' => [
                                'multiple' => false
                            ]
                        ]
                    ],
                    'license'    => []
                ]
            ],
            'text-solution'         => [
                'title'       => 'id',
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\TextSolutionForm',
                        'fields' => [
                            'content',
                            'changes'
                        ]
                    ],
                    'link'       => [
                        'parents' => [
                            'text-exercise'         => [
                                'multiple' => false
                            ],
                            'grouped-text-exercise' => [
                                'multiple' => false
                            ]
                        ]
                    ],
                    'license'    => []
                ]
            ],
            'video'                 => [
                'content'    => 'description',
                'components' => [
                    'repository'      => [
                        'form'   => __NAMESPACE__ . '\Form\VideoForm',
                        'fields' => [
                            'title',
                            'description',
                            'content',
                            'reasoning',
                            'changes'
                        ]
                    ],
                    'license'         => [],
                    'taxonomy'        => [],
                    'related_content' => [],
                    'search'          => []
                ],
            ],
            'text-hint'             => [
                'title'       => 'id',
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\TextHintForm',
                        'fields' => [
                            'content'
                        ]
                    ],
                    'link'       => [
                        'parents' => [
                            'text-exercise'         => [
                                'multiple' => false
                            ],
                            'grouped-text-exercise' => [
                                'multiple' => false
                            ]
                        ]
                    ],
                    'license'    => []
                ]
            ],
            'article'               => [
                'description' => 'content',
                'components'  => [
                    'repository'      => [
                        'form'   => __NAMESPACE__ . '\Form\ArticleForm',
                        'fields' => [
                            'title',
                            'content',
                            'reasoning',
                            'changes'
                        ]
                    ],
                    'license'         => [],
                    'taxonomy'        => [],
                    'related_content' => [],
                    'search'          => []
                ]
            ],
            'course'                => [
                'content'    => 'description',
                'components' => [
                    'repository'      => [
                        'form'   => __NAMESPACE__ . '\Form\ModuleForm',
                        'fields' => [
                            'title',
                            'description',
                            'reasoning',
                            'changes'
                        ]
                    ],
                    'link'            => [
                        'children' => [
                            'course-page' => [
                                'multiple' => true
                            ]
                        ]
                    ],
                    'license'         => [],
                    'taxonomy'        => [],
                    'related_content' => [],
                    'search'          => [],
                    'redirect'        => [
                        'toType' => 'course-page'
                    ]
                ]
            ],
            'course-page'           => [
                'description' => 'content',
                'components'  => [
                    'repository' => [
                        'form'   => __NAMESPACE__ . '\Form\ModulePageForm',
                        'fields' => [
                            'title',
                            'icon',
                            'content',
                            'changes'
                        ]
                    ],
                    'link'       => [
                        'parents' => [
                            'course' => [
                                'multiple' => false
                            ]
                        ]
                    ],
                    'license'    => []
                ]
            ]
        ]
    ]
];
