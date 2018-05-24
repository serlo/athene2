<?php
namespace Newsletter;

return [
    'service_manager'    => [
        'factories' => [
            '\DrewM\MailChimp\MailChimp' =>  __NAMESPACE__ . '\Factory\MailChimpFactory',
            __NAMESPACE__ . '\Listener\UserControllerListener' => __NAMESPACE__ . '\Factory\UserControllerListenerFactory',
        ]
    ]
];
