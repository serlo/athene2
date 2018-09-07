<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui;

return [
    'navigation'         => [
        'hydratables' => [
            'default'   => [
                'hydrators' => [],
            ],
            'top-right' => [
                'hydrators' => [],
            ],
        ],
    ],
    'zfctwig'            => [
        'helper_manager' => [
            'invokables' => [
                'partial' => 'Zend\View\Helper\Partial',
                'encrypt' => 'Ui\View\Helper\Encrypt',
            ],
            'factories'  => [
                'brand'    => __NAMESPACE__ . '\Factory\BrandHelperFactory',
                'tracking' => __NAMESPACE__ . '\Factory\TrackingFactory',
            ],
        ],
    ],
    'view_manager'       => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'athene2-editor' => __DIR__ . '/../templates/editor/layout.phtml',
            'layout/de/home' => __DIR__ . '/../templates/layout/de/serlo-home.phtml',
            'layout/en/home' => __DIR__ . '/../templates/layout/en/serlo-home.phtml',
            'layout/1-col'   => __DIR__ . '/../templates/layout/1-col.phtml',
            'layout/layout'  => __DIR__ . '/../templates/layout/2-col.phtml',
            'layout/3-col'   => __DIR__ . '/../templates/layout/3-col.phtml',
            'error/404'      => __DIR__ . '/../templates/error/404.phtml',
            'error/403'      => __DIR__ . '/../templates/error/403.phtml',
            'error/index'    => __DIR__ . '/../templates/error/index.phtml',
        ],
        'strategies'               => [
            'Zend\View\Strategy\JsonStrategy',
            'ViewFeedStrategy',
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'brand' => __NAMESPACE__ . '\Factory\BrandPluginFactory',
        ],
    ],
    'view_helpers'       => [
        'factories'  => [
            'recaptcha'   => __NAMESPACE__ . '\Factory\RecaptchaHelperFactory',
            'assetsHost'  => __NAMESPACE__ . '\Factory\AssetsHostHelperFactory',
            'pageHeader'  => __NAMESPACE__ . '\Factory\PageHeaderFactory',
            'brand'       => __NAMESPACE__ . '\Factory\BrandHelperFactory',
            'twigPartial' => __NAMESPACE__ . '\Factory\TwigPartialFactory',
            'tracking'    => __NAMESPACE__ . '\Factory\TrackingFactory',
        ],
        'invokables' => [
            'encrypt'      => 'Ui\View\Helper\Encrypt',
            'timeago'      => 'Ui\View\Helper\Timeago',
            'registry'     => 'Ui\View\Helper\Registry',
            'toAlpha'      => 'Ui\View\Helper\ToAlpha',
            'prerelease'   => 'Ui\View\Helper\PreRelease',
            'diff'         => 'Ui\View\Helper\DiffHelper',
            'preview'      => 'Ui\View\Helper\PreviewHelper',
            'randomBanner' => 'Ui\View\Helper\RandomBanner',
        ],
    ],
    'service_manager'    => [
        'factories' => [
            'Ui\Renderer\PhpDebugRenderer'                     => __NAMESPACE__ . '\Factory\PhpDebugRenderFactory',
            __NAMESPACE__ . '\Options\BrandHelperOptions'      => __NAMESPACE__ . '\Factory\BrandHelperOptionsFactory',
            __NAMESPACE__ . '\Options\TrackingHelperOptions'   => __NAMESPACE__ . '\Factory\TrackingHelperOptionsFactory',
            __NAMESPACE__ . '\Options\PageHeaderHelperOptions' => __NAMESPACE__ . '\Factory\PageHeaderHelperOptionsFactory',
        ],
    ],
];
