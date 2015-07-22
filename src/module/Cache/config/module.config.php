<?php

/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org]
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Cache;

return [
    'strokercache' => [
        'id_generator' => 'AjaxGenerator',
        'id_generators' => array(
            'plugin_manager' => array(
                'invokables' => array(
                    'AjaxGenerator' => 'Cache\IdGenerator\AjaxGenerator'
                ),
            ),
        ),
    ]
];
