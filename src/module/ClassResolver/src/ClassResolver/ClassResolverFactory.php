<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace ClassResolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClassResolverFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $seviceLocator)
    {
        $config = $seviceLocator->get('config')['class_resolver'];

        $instance = new ClassResolver($config);
        $instance->setServiceLocator($seviceLocator);

        return $instance;
    }
}
