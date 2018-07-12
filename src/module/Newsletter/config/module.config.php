<?php
namespace Newsletter;

return [
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . 'MailChimp'                        => __NAMESPACE__ . '\Factory\MailChimpFactory',
            __NAMESPACE__ . '\Listener\UserControllerListener' => __NAMESPACE__ . '\Factory\UserControllerListenerFactory',
        ],
    ],
];
