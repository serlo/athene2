<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	    LGPL-3.0
 * @license	    http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright	Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace AtheneTest;

use Zend\Loader\AutoloaderFactory;
use RuntimeException;
error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);
date_default_timezone_set('UTC');

/**
 * @codeCoverageIgnore
 */
class Bootstrap
{

    protected static $serviceManager;
    
    protected static $application;

    public static function getApplication(){
        return static::$application;
    }

    public static $dir;

    public static function init()
    {
        static::$dir = __DIR__;
        static::initAutoloader();
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');
        
        $zf2Path = getenv('ZF2_PATH');
        if (! $zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } elseif (is_dir($vendorPath . '/ZF2/library')) {
                $zf2Path = $vendorPath . '/ZF2/library';
            } elseif (is_dir($vendorPath . '/zendframework/zendframework/library')) {
                $zf2Path = $vendorPath . '/zendframework/zendframework/library';
            }
        }
        
        if (! $zf2Path) {
            throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or' . ' define a ZF2_PATH environment variable.');
        }
        
        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }
        
        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        
        $namespaces = array(
            __NAMESPACE__ => __DIR__
        );
        
        $modulePath = self::findParentPath('module');
        
        if ($handle = opendir(static::findParentPath('src/module') )) {
            while (false !== ($file = readdir($handle))) {
                if (substr($file, 0, 1) != '.') {
                    $namespaces[$file] = $modulePath . '/' . $file . '/src/' . $file;
                    $namespaces[$file . 'Test'] = $modulePath . '/' . $file . '/test/' . $file . 'Test';
                }
            }
            closedir($handle);
        }
        
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => $namespaces
            )
        ));
    }

    public static function findParentPath($path)
    {
        $dir = static::$dir;
        $previousDir = '.';
        while (! is_dir($dir . '/' . $path) && ! file_exists($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir)
                return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
Bootstrap::chroot();