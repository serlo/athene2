<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\Manager;

use Authorization\Service\AuthorizationAssertionTrait;
use ClassResolver\ClassResolverAwareTrait;
use ClassResolver\ClassResolverInterface;
use Common\Traits\FlushableTrait;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\ClassUtils;
use Instance\Manager\InstanceAwareEntityManager;
use Uuid\Entity\UuidInterface;
use Uuid\Exception;
use Uuid\Exception\NotFoundException;
use Uuid\Options\ModuleOptions;
use Zend\EventManager\EventManagerAwareTrait;
use ZfcRbac\Service\AuthorizationService;

class UuidManager implements UuidManagerInterface
{
    use ObjectManagerAwareTrait, ClassResolverAwareTrait;
    use EventManagerAwareTrait, FlushableTrait;
    use AuthorizationAssertionTrait;

    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @param AuthorizationService       $authorizationService
     * @param ClassResolverInterface     $classResolver
     * @param ModuleOptions              $moduleOptions
     * @param InstanceAwareEntityManager $objectManager
     */
    public function __construct(
        AuthorizationService $authorizationService,
        ClassResolverInterface $classResolver,
        ModuleOptions $moduleOptions,
        InstanceAwareEntityManager $objectManager
    ) {
        $this->authorizationService = $authorizationService;
        $this->classResolver        = $classResolver;
        $this->objectManager        = $objectManager;
        $this->moduleOptions        = $moduleOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $className = $this->getClassResolver()->resolveClassName('Uuid\Entity\UuidInterface');
        $entities  = $this->getObjectManager()->getRepository($className)->findAll();
        return new ArrayCollection($entities);
    }

    /**
     * {@inheritDoc}
     */
    public function findByTrashed($trashed)
    {
        $className = $this->getClassResolver()->resolveClassName('Uuid\Entity\UuidInterface');
        $criteria  = ['trashed' => $trashed];
        $entities  = $this->getObjectManager()->getRepository($className)->findBy($criteria);

        return new ArrayCollection($entities);
    }

    /**
     * {@inheritDoc}
     */
    public function getUuid($key, $bypassIsolation = false)
    {
        $previous = $this->objectManager->getBypassIsolation();
        $this->objectManager->setBypassIsolation($bypassIsolation);

        $className = $this->getClassResolver()->resolveClassName('Uuid\Entity\UuidInterface');
        $entity    = $this->getObjectManager()->find($className, $key);
        $this->objectManager->setBypassIsolation($previous);

        if (!is_object($entity)) {
            throw new NotFoundException(sprintf('Could not find %s', $key));
        }

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function purgeUuid($id)
    {
        $uuid       = $this->getUuid($id);
        $class      = ClassUtils::getClass($uuid);
        $permission = $this->moduleOptions->getPermission($class, 'purge');
        $this->assertGranted($permission, $uuid);
        $this->getObjectManager()->remove($uuid);
        $this->getEventManager()->trigger('purge', $this, ['object' => $uuid]);
    }

    /**
     * {@inheritDoc}
     */
    public function restoreUuid($id)
    {
        $uuid       = $this->getUuid($id);
        $class      = ClassUtils::getClass($uuid);
        $permission = $this->moduleOptions->getPermission($class, 'restore');
        $this->assertGranted($permission, $uuid);

        if (!$uuid->isTrashed()) {
            return;
        }

        $uuid->setTrashed(false);
        $this->getObjectManager()->persist($uuid);

        $this->getEventManager()->trigger('restore', $this, ['object' => $uuid]);
    }

    /**
     * {@inheritDoc}
     */
    public function trashUuid($id)
    {
        $uuid       = $this->getUuid($id);
        $class      = ClassUtils::getClass($uuid);
        $permission = $this->moduleOptions->getPermission($class, 'trash');
        $this->assertGranted($permission, $uuid);

        if ($uuid->isTrashed()) {
            return;
        }

        $uuid->setTrashed(true);
        $this->getObjectManager()->persist($uuid);

        $this->getEventManager()->trigger('trash', $this, ['object' => $uuid]);
    }

    /**
     * @param int|UuidInterface $idOrObject
     * @return UuidInterface
     * @throws \Uuid\Exception\InvalidArgumentException
     */
    protected function ambiguousToUuid($idOrObject)
    {
        $uuid = null;

        if (is_int($idOrObject)) {
            $uuid = $this->getUuid($idOrObject);
        } elseif ($idOrObject instanceof UuidInterface) {
            $uuid = $idOrObject;
        } else {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected int, UuidInterface or UuidInterface but got "%s"',
                (is_object($idOrObject) ? get_class($idOrObject) : gettype($idOrObject))
            ));
        }

        return $uuid;
    }
}
