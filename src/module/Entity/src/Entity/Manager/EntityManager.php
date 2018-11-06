<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Manager;

use Authorization\Service\AuthorizationAssertionTrait;
use ClassResolver\ClassResolverAwareTrait;
use Common\Traits\FlushableTrait;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Entity\Entity\EntityInterface;
use Entity\Entity\RevisionInterface;
use Entity\Exception;
use Instance\Entity\InstanceInterface;
use Type\TypeManagerAwareTrait;
use Uuid\Manager\UuidManagerAwareTrait;
use Zend\EventManager\EventManagerAwareTrait;
use Entity\Entity\Entity;

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
        $type = $this->getTypeManager()->findTypeByName($typeName);

        $entity->setInstance($instance);
        $entity->setType($type);
        $this->getEventManager()->trigger('create', $this, [
            'entity' => $entity,
            'data' => $data
        ]);
        $this->getObjectManager()->persist($entity);

        return $entity;
    }

    public function findAll($bypassInstanceIsolation = false)
    {
        $old = $this->objectManager->getBypassIsolation();
        $this->objectManager->setBypassIsolation($bypassInstanceIsolation);
        $className = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        $results = $this->getObjectManager()
            ->getRepository($className)
            ->findAll();
        $this->objectManager->setBypassIsolation($old);
        return new ArrayCollection($results);
    }

    public function findEntitiesByTypeName($name, $bypassInstanceIsolation = false)
    {
        $old = $this->objectManager->getBypassIsolation();
        $this->objectManager->setBypassIsolation($bypassInstanceIsolation);
        $className = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        $type = $this->getTypeManager()->findTypeByName($name);
        $results = $this->getObjectManager()
            ->getRepository($className)
            ->findBy([
            'type' => $type->getId()
        ]);
        $this->objectManager->setBypassIsolation($old);
        return new ArrayCollection($results);
    }

    public function getEntity($id)
    {
        $className = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        $entity = $this->getObjectManager()->find($className, $id);

        if (! is_object($entity)) {
            throw new Exception\EntityNotFoundException(sprintf('Entity "%d" not found.', $id));
        }
        $this->assertGranted('entity.get', $entity);

        return $entity;
    }

    public function findAllUnrevised()
    {
        $entityClassName = $this->getClassResolver()->resolveClassName('Entity\Entity\EntityInterface');
        //TODO: unhack
        $sql = 'SELECT DISTINCT e1_.id AS id FROM entity_revision e2_ INNER JOIN `uuid` u3_ ON e2_.id = u3_.id INNER JOIN entity e1_ ON (e1_.id = e2_.repository_id) WHERE ( e1_.current_revision_id IS NULL OR e2_.id > e1_.current_revision_id ) AND u3_.trashed = 0';
        $q = $this->objectManager->getConnection()->prepare($sql);
        $q->execute();
        $unrevisedEntityIdsNested = $q->fetchAll();
        $unrevisedEntityIds = [];
        foreach ($unrevisedEntityIdsNested as $unrevisedEntityIdArray) {
            $unrevisedEntityIds[] = $unrevisedEntityIdArray["id"];
        }
        $results = $this->getObjectManager()->getRepository($entityClassName)->findBy([
            'id' => $unrevisedEntityIds
        ]);
        return new ArrayCollection($results);
    }
}
