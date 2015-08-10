<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Markdown;

return [
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Options\ModuleOptions'     => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\Storage\MarkdownStorage'   => __NAMESPACE__ . '\Factory\MarkdownStorageFactory',
            __NAMESPACE__ . '\Service\HtmlRenderService' => __NAMESPACE__ . '\Factory\HtmlRenderServiceFactory'
        ]
    ],
    'view_helpers'    => [
        'factories' => [
            'markdown' => __NAMESPACE__ . '\Factory\MarkdownHelperFactory'
        ]
    ],
    'di'              => [
        'instance' => [
            'preferences' => [
                __NAMESPACE__ . '\Service\CacheServiceInterface'  => __NAMESPACE__ . '\Service\CacheService',
                __NAMESPACE__ . '\Service\RenderServiceInterface' => __NAMESPACE__ . '\Service\HtmlRenderService'
            ]
        ]
    ]
];