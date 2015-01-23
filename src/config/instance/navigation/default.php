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
            'search'     => [
                'label' => 'Search',
                'route' => 'search',
                'pages' => [
                    [
                        'label' => 'Search',
                        'route' => 'search',
                        'icon'  => 'search'
                    ]
                ]
            ],
            'restricted' => [
                'label'         => 'Backend',
                'uri'           => '#',
                'needsIdentity' => true,
                'pages'         => [
                    [
                        'label' => 'Home',
                        'icon'  => 'home',
                        'route' => 'backend'
                    ],
                    [
                        'label' => 'Pages',
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
                        ]
                    ],
                    [
                        'label' => 'Taxonomy',
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
                        ]
                    ],
                    [
                        'label' => 'Authorization',
                        'icon'  => 'lock',
                        'route' => 'authorization/roles'
                    ],
                    [
                        'label' => 'Navigation',
                        'icon'  => 'list-alt',
                        'route' => 'navigation/manage',
                        'pages' => [
                            [
                                'route'   => 'navigation/container/get',
                                'visible' => false
                            ],
                            [
                                'route'   => 'navigation/page/get',
                                'visible' => false
                            ]
                        ]
                    ],
                    [
                        'label' => 'Users',
                        'icon'  => 'user',
                        'route' => 'users',
                        'pages' => [
                            [
                                'route'   => 'authorization/role/show',
                                'visible' => false
                            ]
                        ]
                    ],
                    [
                        'label' => 'Recycle bin',
                        'icon'  => 'trash',
                        'route' => 'uuid/recycle-bin'
                    ],
                    [
                        'label' => 'Flags',
                        'icon'  => 'flag',
                        'route' => 'flag/manage',
                        'pages' => [
                            [
                                'route'   => 'flag/detail',
                                'visible' => false
                            ]
                        ]
                    ],
                    [
                        'label' => 'Licenses',
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
                        ]
                    ],
                    [
                        'label' => 'Horizon',
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
                        ]
                    ]
                ]
            ],
            'blog'       => [
                'label' => 'Blog',
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
                ]
            ],
            'me'         => [
                'label' => 'Me',
                'uri'   => '#',
                'pages' => [
                    [
                        'route'   => 'user/login',
                        'visible' => false
                    ],
                    [
                        'route'   => 'user/register',
                        'visible' => false
                    ],
                    [
                        'route' => 'user/me',
                        'label' => 'Profile',
                        'icon'  => 'user'
                    ],
                    [
                        'route' => 'user/settings',
                        'label' => 'Settings',
                        'icon'  => 'wrench'
                    ],
                    [
                        'route' => 'authentication/password/change',
                        'label' => 'Update password',
                        'icon'  => 'lock'
                    ],
                    [
                        'route' => 'subscriptions/manage',
                        'label' => 'Subscriptions',
                        'icon'  => 'eye-open'
                    ]
                ]
            ],
            'home'       => [
                'label' => 'Home',
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
