<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2018 Serlo Education e.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright Copyright (c) 2013-2018 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace AtheneTest\TestCase;

use ClassResolver\ClassResolver;

abstract class ManagerTest extends ObjectManagerTestCase
{
    protected $manager;

    protected $classResolver;
    protected $objectManager;
    protected $serviceLocator;

    final public function getManager()
    {
        return $this->manager;
    }

    final public function setManager($manager)
    {
        $this->manager = $manager;
        return $this;
    }

    final protected function mockEntity($className, $id)
    {
        $entity = $this->getMock($className);
        $entity->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));
        return $entity;
    }

    final protected function prepareClassResolver(array $config)
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

    final protected function prepareServiceLocator($inject = true)
    {
        if (! $this->serviceLocator) {
            $this->serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager');
        }

        if ($inject) {
            $this->getManager()->setServiceLocator($this->serviceLocator);
        }

        return $this->serviceLocator;
    }

    final protected function prepareObjectManager($inject = true)
    {
        if (! $this->objectManager) {
            $this->objectManager = $this->mockEntityManager();
        }
        if ($inject) {
            $this->getManager()->setObjectManager($this->objectManager);
        }
        return $this->objectManager;
    }

    final protected function prepareFind($repositoryName, $key, $return)
    {
        $objectManager = $this->prepareObjectManager();

        $objectManager->expects($this->once())
            ->method('find')
            ->with($repositoryName, $key)
            ->will($this->returnValue($return));
    }

    final protected function prepareFindBy($repositoryName, array $criteria, $return)
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

    final protected function prepareFindOneBy($repositoryName, array $criteria, $return)
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
