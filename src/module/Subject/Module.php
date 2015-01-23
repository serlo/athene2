<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RoutePluginManager;
use Zend\Stdlib\ArrayUtils;

class Module
{
    protected static function getInstanceConfigs()
    {
        $return = [];
        $path   = self::findParentPath('config/instances');
        $dir    = __DIR__ . '/';
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                echo $dir . $file . is_dir($dir . $file . '/') . '<br/>';
                flush();
                if ($file != "." && $file != ".." && is_dir($dir . $file)) {
                    $return = ArrayUtils::merge($return, include $dir . $file . '/instance.config.php');
                }
            }
        }

        return $return;
    }

    protected static function findParentPath($path)
    {
        $dir         = __DIR__ . '/';
        $previousDir = '.';
        while (!is_dir($dir . $path) && !file_exists($dir . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }

        return $dir . $path;
    }

    public function getAutoloaderConfig()
    {
        $autoloader = [];

        $autoloader['Zend\Loader\StandardAutoloader'] = [
            'namespaces' => [
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
            ]
        ];

        if (file_exists(__DIR__ . '/autoload_classmap.php')) {
            return [
                'Zend\Loader\ClassMapAutoloader' => [
                    __DIR__ . '/autoload_classmap.php',
                ]
            ];
        }

        return $autoloader;
    }

    public function getConfig()
    {
        return ArrayUtils::merge(include __DIR__ . '/config/module.config.php', $this->getInstanceConfig());
    }

    public function getInstanceConfig()
    {
        $instances = [__DIR__ . '/config/instances.config.php'];
        $config    = [];
        foreach ($instances as $instance) {
            $config = ArrayUtils::merge($config, include $instance);
        }

        return $config;
    }
}
