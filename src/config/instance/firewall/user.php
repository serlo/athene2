<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     LGPL-3.0
 * @license     http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
return [
    'zfc_rbac' => [
        'guards' => [
            'ZfcRbac\Guard\ControllerGuard' => [
                [
                    'controller' => 'User\Controller\UserController',
                    'actions'    => [
                        'profile',
                        'login',
                        'register',
                        'restorePassword',
                        'activate'
                    ],
                    'roles'      => [
                        'guest'
                    ]
                ],
                [
                    'controller' => 'User\Controller\UserController',
                    'actions'    => [
                        'me',
                        'logout',
                        'settings',
                        'changePassword'
                    ],
                    'roles'      => [
                        'login'
                    ]
                ],
                [
                    'controller' => 'User\Controller\UserController',
                    'actions'    => [
                        'addRole',
                        'removeRole',
                        'purge'
                    ],
                    'roles'      => [
                        'sysadmin'
                    ]
                ]
            ]
        ]
    ]
];