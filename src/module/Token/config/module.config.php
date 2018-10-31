<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Token;

return [
    'di' => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Tokenizer',
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Tokenizer' => [
                    'setServiceLocator' => [
                        'required' => true,
                    ],
                ],
            ],
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\TokenizerInterface' => __NAMESPACE__ . '\Tokenizer',
            ],
        ],
    ],
];
