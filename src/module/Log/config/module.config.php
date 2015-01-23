<?php
namespace Log;

return [
    'service_manager' => [
        'factories' => [
            'Zend\Log\Logger' => __NAMESPACE__ . '\Factory\LoggerFactory'
        ]
    ]
];