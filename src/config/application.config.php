<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     LGPL-3.0
 * @license     http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */

$moduleCache = true;
$configCache = false;
if (file_exists(__DIR__ . '/definitions.local.php')) {
    require_once __DIR__ . '/definitions.local.php';
}

return [
    // This should be an array of module namespaces used in the application.
    'modules'                 => [
        // Session needs to be the first entry, so db storage instead of php storage is used!
        'PageSpeed',
        'Session',
        'ZendDeveloperTools',
        'Application',
        'AsseticBundle',
        'DoctrineModule',
        'DoctrineORMModule',
        'StrokerCache',
        'ZfcBase',
        'ZfcRbac',
        'TwbBundle',
        'ZfcTwig',
        'EwgoSolarium',
        'Common',
        'Authentication',
        'Ui',
        'Admin',
        'User',
        'Versioning',
        'Entity',
        'Taxonomy',
        'Link',
        'Subject',
        'Term',
        'Uuid',
        'ClassResolver',
        'Instance',
        'Event',
        'Mailman',
        'Alias',
        'Token',
        'Discussion',
        'Page',
        'Blog',
        'Attachment',
        'RelatedContent',
        'Contexter',
        'Navigation',
        'Flag',
        'Search',
        'Metadata',
        'License',
        'Normalizer',
        'Type',
        'Markdown',
        'Authorization',
        'Taxonomy',
        'Notification',
        'Ads',
        'Log',
        'CacheInvalidator',
        'Cache'
    ],
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths'             => [
            __DIR__ . '/../module',
            __DIR__ . '/../vendor'
        ],
        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively overide configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths'        => [
            'config/autoload/{,*.}{global,local}.php',
            'config/instance/{,*.}{global,local}.php',
            'config/instance/navigation/*.php'
        ],
        // Whether or not to enable a configuration cache.
        // If enabled, the merged configuration will be cached and used in
        // subsequent requests.
        'config_cache_enabled'     => $configCache,
        // The key used to create the configuration cache file name.

        'config_cache_key'         => "2245023265ae4cf87d02c8b6ba994139",
        // Whether or not to enable a module class map cache.
        // If enabled, creates a module class map cache which will be used
        // by in future requests, to reduce the autoloading process.
        'module_map_cache_enabled' => $moduleCache,
        // The key used to create the class map cache file name.
        'module_map_cache_key'     => "496fe9daf9bed5ab03314f04518b9268",
        // The path in which to cache merged configuration.
        'cache_dir'                => __DIR__ . "/../data",
        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        // 'check_dependencies' => true,
    ],
    // Used to create an own service manager. May contain one or more child arrays.
    //'service_listener_options' => array(
    //     array(
    //         'service_manager' => $stringServiceManagerName,
    //         'config_key'      => $stringConfigKey,
    //         'interface'       => $stringOptionalInterface,
    //         'method'          => $stringRequiredMethodName,
    //     ),
    // )

    // Initial configuration with which to seed the ServiceManager.
    // Should be compatible with Zend\ServiceManager\Config.
    // 'service_manager' => array(),
];
