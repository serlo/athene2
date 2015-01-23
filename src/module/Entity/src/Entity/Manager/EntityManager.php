<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Manager;

use Authorization\Service\AuthorizationAssertionTrait;
use ClassResolver\ClassResolverAwareTrait;
use Common\Traits\FlushableTrait;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Entity\Entity\EntityInterface;
use Entity\Exception;
use Instance\Entity\InstanceInterface;
use Type\TypeManagerAwareTrait;
use Uuid\Manager\UuidManagerAwareTrait;
use Zend\EventManager\EventManagerAwareTrait;

class EntityManager implements EntityManagerInterface
{
    use TypeManagerAwareTrait, ObjectManagerAwareTrait;
    use ClassResolverAwareTrait;
    use EventManagerAwareTrait, FlushableTrait;
    use AuthorizationAssertionTrait;

    public function createEntity($typeName, array $data = [], InstanceInterface $instance)
    {
        $this->assertGranted('entity.create', $instance);

        /* @var $entity EntityInterface */
        $entity = $this->getClassResolver()->resolve('Entity\Entity\EntityInterface');
        $type   = $this->getTypeManager()->findTypeByName($typeName);

        $entity->setInstance($instance);
        $entity->setType($type);
        $this->getEventManager()->trigger('create', $this, ['entity' => $entity, 'data' => $data]);
        $this->getObjectManager()->persist($entity);

        return $entity;
    }

    public function findAll($bypassInstanceIsolation = false)
    {
        $old = $this->objectManager->getBypassIsolation();
        $this->objectManager->setBypassIsolation($bypassInstanceIsolation);
        $className = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        $results   = $this->getObjectManager()->getRepository($className)->findAll();
        $this->objectManager->setBypassIsolation($old);
        return new ArrayCollection($results);
    }

    public function findEntitiesByTypeName($name, $bypassInstanceIsolation = false)
    {
        $old = $this->objectManager->getBypassIsolation();
        $this->objectManager->setBypassIsolation($bypassInstanceIsolation);
        $className = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        $type      = $this->getTypeManager()->findTypeByName($name);
        $results   = $this->getObjectManager()->getRepository($className)->findBy(['type' => $type->getId()]);
        $this->objectManager->setBypassIsolation($old);
        return new ArrayCollection($results);
    }

    public function getEntity($id)
    {
        $className = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        $entity    = $this->getObjectManager()->find($className, $id);

        if (!is_object($entity)) {
            throw new Exception\EntityNotFoundException(sprintf('Entity "%d" not found.', $id));
        }
        $this->assertGranted('entity.get', $entity);

        return $entity;
    }
}
