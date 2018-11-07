<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace ClassResolverTest;

use ClassResolver\ClassResolverFactory;
use Zend\ServiceManager\ServiceManager;

class ClassResolverFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'Config',
            [
                'class_resolver' => [
                    'FooInterface' => 'Bar',
                ],
            ]
        );

        $factory       = new ClassResolverFactory();
        $classResolver = $factory->createService($serviceManager);

        $this->assertInstanceOf('ClassResolver\ClassResolver', $classResolver);
        $this->assertSame($serviceManager, $classResolver->getServiceLocator());
    }
}
