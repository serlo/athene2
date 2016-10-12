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
                'label' => t('Backend'),
                'route' => 'backend',
                'needsIdentity' => true,
                'translate' => true,
                'pages' => [
                    [
                        'label' => t('Pages'),
                        'route' => 'pages',
                        'icon' => 'paperclip',
                        'translate' => true,
                        'pages' => [
                            [
                                'label' => t('Create a page'),
                                'route' => 'page/create',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Update a page'),
                                'route' => 'page/update',
                                'visible' => false,
                                'translate' => true
                            ]
                        ]
                    ],
                    [
                        'label' => t('Taxonomy'),
                        'route' => 'taxonomy/term/organize-all',
                        'icon' => 'book',
                        'translate' => true,
                        'pages' => [
                            [
                                'label' => t('Organize'),
                                'route' => 'taxonomy/term/organize',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'route' => 'taxonomy/term/action',
                                'visible' => false
                            ],
                            [
                                'route' => 'taxonomy/term/create',
                                'visible' => false
                            ],
                            [
                                'route' => 'taxonomy/term/update',
                                'visible' => false
                            ],
                            [
                                'route' => 'taxonomy/term/sort-associated',
                                'visible' => false
                            ]
                        ]
                    ],
                    [
                        'label' => t('Authorization'),
                        'icon' => 'lock',
                        'route' => 'authorization/roles',
                        'translate' => true,
                        'pages' => [
                            [
                                'label' => t('Role'),
                                'route' => 'authorization/role/show',
                                'visible' => false,
                                'translate' => true,
                            ],
                            [
                                'label' => t('Create role'),
                                'route' => 'authorization/role/create',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Add user'),
                                'route' => 'authorization/role/user/add',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Add permission'),
                                'route' => 'authorization/role/permission/add',
                                'visible' => false,
                                'translate' => true
                            ]
                        ],
                    ],
                    [
                        'label' => t('Navigation'),
                        'icon' => 'list-alt',
                        'route' => 'navigation/manage',
                        'translate' => true,
                        'pages' => [
                            [
                                'label' => t('Manage navigation'),
                                'route' => 'navigation/container/get',
                                'visible' => false,
                            ],
                            [
                                'label' => t('Create container'),
                                'route' => 'navigation/container/create',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'route' => 'navigation/page/get',
                                'visible' => false
                            ],
                            [
                                'label' => t('Create parameter'),
                                'route' => 'navigation/parameter/create',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Create parameter key'),
                                'route' => 'navigation/parameter/key/create',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Update parameter'),
                                'route' => 'navigation/parameter/update',
                                'visible' => false,
                                'translate' => true
                            ]
                        ]
                    ],
                    [
                        'label' => t('Users'),
                        'icon' => 'user',
                        'route' => 'users',
                        'translate' => true
                    ],
                    [
                        'label' => t('Recycle bin'),
                        'icon' => 'trash',
                        'route' => 'uuid/recycle-bin',
                        'translate' => true
                    ],
                    [
                        'label' => t('Flags'),
                        'icon' => 'flag',
                        'route' => 'flag/manage',
                        'translate' => true,
                        'pages' => [
                            [
                                'label' => t('Flag detail'),
                                'route' => 'flag/detail',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Flag content'),
                                'route' => 'flag/add',
                                'visible' => false,
                                'translate' => true
                            ]
                        ]
                    ],
                    [
                        'label' => t('Licenses'),
                        'icon' => 'tags',
                        'route' => 'license/manage',
                        'translate' => true,
                        'pages' => [
                            [
                                'label' => t('Add license'),
                                'route' => 'license/add',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('License'),
                                'route' => 'license/detail',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'route' => 'license/update',
                                'visible' => false
                            ]
                        ]
                    ],
                    [
                        'label' => t('Horizon'),
                        'icon' => 'globe',
                        'route' => 'ads',
                        'pages' => [
                            [
                                'label' => t('Create ad'),
                                'route' => 'ads/add',
                                'visible' => false,
                                'translate' => true
                            ],
                            [
                                'label' => t('Update ad'),
                                'route' => 'ads/ad/edit',
                                'visible' => false,
                                'translate' => true
                            ]
                        ],
                        'translate' => true
                    ]
                ]
            ],
            'blog' => [
                'label' => t('Blog'),
                'route' => 'blog',
                'translate' => true,
                'pages' => [
                    [
                        'route' => 'blog/post/create',
                        'visible' => false
                    ],
                    [
                        'route' => 'blog/post/view',
                        'visible' => false
                    ]
                ]
            ],
            'me' => [
                'label' => t('Me'),
                'uri' => '#',
                'translate' => true,
                'pages' => [
                    [
                        'route' => 'user/login',
                        'visible' => false,
                    ],
                    [
                        'route' => 'user/register',
                        'visible' => false
                    ],
                    [
                        'label' => t('Profile'),
                        'route' => 'user/me',
                        'icon' => 'user',
                        'translate' => true
                    ],
                    [
                        'label' => t('Edit profile'),
                        'route' => 'user/settings',
                        'icon' => 'wrench',
                        'translate' => true
                    ],
                    [
                        'label' => t('Update password'),
                        'route' => 'authentication/password/change',
                        'icon' => 'lock',
                        'translate' => true
                    ],
                    [
                        'label' => t('Subscriptions'),
                        'route' => 'subscriptions/manage',
                        'icon' => 'eye-open',
                        'translate' => true
                    ],
                    [
                        'label' => t('Event log'),
                        'route' => 'event/history/user/me',
                        'translate' => true
                    ]
                ]
            ],
            'home' => [
                'route' => 'home',
                'pages' => [
                    [
                        'route' => 'home',
                        'visible' => false
                    ]
                ]
            ]
        ]
    ]
];
