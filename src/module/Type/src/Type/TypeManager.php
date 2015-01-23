<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Type;

use ClassResolver\ClassResolverAwareTrait;
use ClassResolver\ClassResolverInterface;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class TypeManager implements TypeManagerInterface
{
    use ObjectManagerAwareTrait, ClassResolverAwareTrait;

    public function __construct(ClassResolverInterface $classResolver, ObjectManager $objectManager)
    {
        $this->classResolver = $classResolver;
        $this->objectManager = $objectManager;
    }

    public function getType($id)
    {
        $className = $this->getEntityClassName();
        $type      = $this->getObjectManager()->find($className, $id);
        if (!is_object($type)) {
            throw new Exception\TypeNotFoundException(sprintf('Type "%d" not found.', $id));
        }
        return $type;
    }

    public function findAllTypes()
    {
        $className  = $this->getEntityClassName();
        $repository = $this->getObjectManager()->getRepository($className);
        return new ArrayCollection($repository->findAll());
    }

    public function findTypeByName($name)
    {
        $className  = $this->getEntityClassName();
        $repository = $this->getObjectManager()->getRepository($className);
        $type       = $repository->findOneBy(['name' => $name]);

        if (!is_object($type)) {
            throw new Exception\TypeNotFoundException(sprintf('Type "%s" not found.', $name));
        }

        return $type;
    }

    public function findTypesByNames(array $names)
    {
        $className  = $this->getEntityClassName();
        $repository = $this->getObjectManager()->getRepository($className);
        return new ArrayCollection($repository->findBy(['name' => $names]));
    }

    protected function getEntityClassName()
    {
        return $this->getClassResolver()->resolveClassName('Type\Entity\TypeInterface');
    }
}
