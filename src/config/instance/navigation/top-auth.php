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
    'navigation' => [
        'top-auth' => [
            [
                'label'         => '',
                'route'         => 'user/me',
                'icon'          => 'user',
                'needsIdentity' => true
            ],
            [
                'label'         => 'Sign up',
                'route'         => 'user/register',
                'needsIdentity' => false
            ],
            [
                'label'         => 'Log in',
                'route'         => 'authentication/login',
                'icon'          => 'user',
                'needsIdentity' => false
            ],
            [
                'label'         => 'Log out',
                'route'         => 'authentication/logout',
                'needsIdentity' => true
            ]
        ]
    ]
];