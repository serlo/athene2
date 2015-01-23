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
namespace AtheneTest\TestCase;

use ClassResolver\ClassResolver;

abstract class ManagerTest extends ObjectManagerTestCase
{

    protected $manager;

    protected $classResolver, $objectManager, $serviceLocator;

    public final function getManager()
    {
        return $this->manager;
    }

    public final function setManager($manager)
    {
        $this->manager = $manager;
        return $this;
    }

    protected final function mockEntity($className, $id)
    {
        $entity = $this->getMock($className);
        $entity->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));
        return $entity;
    }

    protected final function prepareClassResolver(array $config)
    {
        if ($this->classResolver) {
            return $this->classResolver;
        }
        
        $this->classResolver = new ClassResolver($config);
        $serviceLocator = $this->prepareServiceLocator(false);
        
        $this->getManager()->setClassResolver($this->classResolver);
        $this->classResolver->setServiceLocator($serviceLocator);
        
        return $this->classResolver;
    }

    protected final function prepareServiceLocator($inject = true)
    {
        if (! $this->serviceLocator) {
            $this->serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager');
        }
        
        if ($inject) {
            $this->getManager()->setServiceLocator($this->serviceLocator);
        }
        
        return $this->serviceLocator;
    }

    protected final function prepareObjectManager($inject = true)
    {
        if (! $this->objectManager) {
            $this->objectManager = $this->mockEntityManager();
        }
        if ($inject) {
            $this->getManager()->setObjectManager($this->objectManager);
        }
        return $this->objectManager;
    }

    protected final function prepareFind($repositoryName, $key, $return)
    {
        $objectManager = $this->prepareObjectManager();
        
        $objectManager->expects($this->once())
            ->method('find')
            ->with($repositoryName, $key)
            ->will($this->returnValue($return));
    }

    protected final function prepareFindBy($repositoryName, array $criteria, $return)
    {
        $objectManager = $this->prepareObjectManager();
        $repository = $this->mockEntityRepository();
        
        $objectManager->expects($this->once())
            ->method('getRepository')
            ->with($repositoryName)
            ->will($this->returnValue($repository));
        
        $repository->expects($this->once())
            ->method('findBy')
            ->with($criteria)
            ->will($this->returnValue($return));
    }

    protected final function prepareFindOneBy($repositoryName, array $criteria, $return)
    {
        $objectManager = $this->prepareObjectManager();
        $repository = $this->mockEntityRepository();
        
        $objectManager->expects($this->once())
            ->method('getRepository')
            ->with($repositoryName)
            ->will($this->returnValue($repository));
        
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with($criteria)
            ->will($this->returnValue($return));
    }
}