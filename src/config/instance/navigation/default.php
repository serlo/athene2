<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license     LGPL-3.0
 * @license     http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
return [
    'navigation' => [
        'default' => [
            'restricted' => [
                'label'         => t('Backend'),
                'route'         => 'backend',
                'needsIdentity' => true,
                'translate'     => true,
                'pages'         => [
                    [
                        'label' => t('Pages'),
                        'route' => 'pages',
                        'icon'  => 'paperclip',
                        'pages' => [
                            [
                                'route'   => 'page/create',
                                'visible' => false
                            ],
                            [
                                'route'   => 'page/update',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ],
                    [
                        'label' => t('Taxonomy'),
                        'route' => 'taxonomy/term/organize-all',
                        'icon'  => 'book',
                        'pages' => [
                            [
                                'route'   => 'taxonomy/term/action',
                                'visible' => false
                            ],
                            [
                                'route'   => 'taxonomy/term/create',
                                'visible' => false
                            ],
                            [
                                'route'   => 'taxonomy/term/update',
                                'visible' => false
                            ],
                            [
                                'route'   => 'taxonomy/term/sort-associated',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ],
                    [
                        'label' => t('Authorization'),
                        'icon'  => 'lock',
                        'route' => 'authorization/roles',
                        'translate' => true
                    ],
                    [
                        'label' => t('Navigation'),
                        'icon'  => 'list-alt',
                        'route' => 'navigation/manage',
                        'pages' => [
                            [
                                'label'     => t('Manage navigation'),
                                'route'     => 'navigation/container/get',
                                'visible'   => false,
                                'translate' => true
                            ],
                            [
                                'route'   => 'navigation/page/get',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ],
                    [
                        'label' => t('Users'),
                        'icon'  => 'user',
                        'route' => 'users',
                        'pages' => [
                            [
                                'route'   => 'authorization/role/show',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ],
                    [
                        'label' => t('Recycle bin'),
                        'icon'  => 'trash',
                        'route' => 'uuid/recycle-bin',
                        'translate' => true
                    ],
                    [
                        'label' => t('Flags'),
                        'icon'  => 'flag',
                        'route' => 'flag/manage',
                        'pages' => [
                            [
                                'route'   => 'flag/detail',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ],
                    [
                        'label' => t('Licenses'),
                        'icon'  => 'tags',
                        'route' => 'license/manage',
                        'pages' => [
                            [
                                'route'   => 'license/add',
                                'visible' => false
                            ],
                            [
                                'route'   => 'license/update',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ],
                    [
                        'label' => t('Horizon'),
                        'icon'  => 'globe',
                        'route' => 'ads',
                        'pages' => [
                            [
                                'route'   => 'ads/add',
                                'visible' => false
                            ],
                            [
                                'route'   => 'ads/ad/edit',
                                'visible' => false
                            ]
                        ],
                        'translate' => true
                    ]
                ]
            ],
            'blog' => [
                'label' => t('Blog'),
                'route' => 'blog',
                'pages' => [
                    [
                        'route'   => 'blog/post/create',
                        'visible' => false
                    ],
                    [
                        'route'   => 'blog/post/view',
                        'visible' => false
                    ]
                ],
                'translate' => true
            ],
            'me' => [
                'label' => t('Me'),
                'uri'   => '#',
                'pages' => [
                    [
                        'route'   => 'user/login',
                        'visible' => false,
                    ],
                    [
                        'route'   => 'user/register',
                        'visible' => false
                    ],
                    [
                        'route' => 'user/me',
                        'label' => t('Profile'),
                        'icon'  => 'user',
                        'translate' => true
                    ],
                    [
                        'route' => 'user/settings',
                        'label' => t('Edit profile'),
                        'icon'  => 'wrench',
                        'translate' => true
                    ],
                    [
                        'route' => 'authentication/password/change',
                        'label' => t('Update password'),
                        'icon'  => 'lock',
                        'translate' => true
                    ],
                    [
                        'route' => 'subscriptions/manage',
                        'label' => t('Subscriptions'),
                        'icon'  => 'eye-open',
                        'translate' => true
                    ]
                ],
                'translate' => true
            ],
            'home' => [
                'route' => 'home',
                'pages' => [
                    [
                        'route'   => 'home',
                        'visible' => false
                    ]
                ]
            ]
        ]
    ]
];
