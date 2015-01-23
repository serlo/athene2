<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Token;

return [
    'di' => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Tokenizer'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Tokenizer' => [
                    'setServiceLocator' => [
                        'required' => true
                    ]
                ]
            ]
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\TokenizerInterface' => __NAMESPACE__ . '\Tokenizer'
            ]
        ]
    ]
];