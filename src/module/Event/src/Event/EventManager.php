<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event;

use Authorization\Service\AuthorizationAssertionTrait;
use ClassResolver\ClassResolverAwareTrait;
use ClassResolver\ClassResolverInterface;
use Common\Paginator\DoctrinePaginatorFactory;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Event\Exception;
use Event\Filter\PersistentEventLogFilterChain;
use Instance\Entity\InstanceInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;
use ZfcRbac\Exception\UnauthorizedException;
use ZfcRbac\Service\AuthorizationService;

class EventManager implements EventManagerInterface
{
    use ObjectManagerAwareTrait, ClassResolverAwareTrait;
    use AuthorizationAssertionTrait;

    /**
     * @var array
     */
    protected $inMemoryEvents = [];

    /**
     * @var array
     */
    protected $inMemoryParameterNames = [];

    /**
     * @var PersistentEventLogFilterChain
     */
    protected $persistentEventLogFilterChain;

    public function __construct(
        AuthorizationService $authorizationService,
        ClassResolverInterface $classResolver,
        ObjectManager $objectManager
    ) {
        $this->objectManager                 = $objectManager;
        $this->persistentEventLogFilterChain = new PersistentEventLogFilterChain($objectManager);
        $this->classResolver                 = $classResolver;
        $this->setAuthorizationService($authorizationService);
    }

    public function findEventsByNamesAndActor(UserInterface $user, array $names){
        $events = [];
        foreach ($names as $name) {
            $event = $this->findTypeByName($name);
            $className  = $this->getClassResolver()->resolveClassName('Event\Entity\EventLogInterface');
            $repository = $this->getObjectManager()->getRepository($className);
            $results    = $repository->findBy(['actor' => $user, 'event' => $event]);
            $events = array_merge($results, $events);
        }
        return new ArrayCollection($events);
    }

    public function findEventsByActor($userId, $limit = 50)
    {
        if (!is_numeric($userId)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected numeric but got "%s"',
                gettype($userId)
            ));
        }

        $className  = $this->getClassResolver()->resolveClassName('Event\Entity\EventLogInterface');
        $repository = $this->getObjectManager()->getRepository($className);
        $results    = $repository->findBy(['actor' => $userId], ['id' => 'desc'], $limit);
        $collection = new ArrayCollection($results);

        $collection = $this->persistentEventLogFilterChain->filter($collection);

        foreach ($collection as $result) {
            $this->assertGranted('event.log.get', $result);
        }

        return $collection;
    }

    public function findEventsByObject($objectId, $recursive = true, array $filters = [])
    {
        if (!is_numeric($objectId)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected numeric but got `%s`',
                gettype($objectId)
            ));
        }

        $className  = $this->getClassResolver()->resolveClassName('Event\Entity\EventLogInterface');
        $repository = $this->getObjectManager()->getRepository($className);
        $results    = $repository->findBy(['uuid' => $objectId]);

        if ($recursive) {
            $repository = $this->getObjectManager()->getRepository('Event\Entity\EventParameterUuid');
            $parameters = $repository->findBy(['uuid' => $objectId]);

            foreach ($parameters as $parameter) {
                $parameter = $parameter->getEventParameter();
                if (!empty($filters)) {
                    if (in_array($parameter->getName(), $filters)) {
                        $results[] = $parameter->getLog();
                    }
                } else {
                    $results[] = $parameter->getLog();
                }
            }
        }

        $collection = [];
        foreach ($results as $result) {
            $this->assertGranted('event.log.get', $result);
            $collection[$result->getId()] = $result;
        }
        ksort($collection);
        rsort($collection);
        $collection = new ArrayCollection($collection);

        return $this->persistentEventLogFilterChain->filter($collection);
    }

    public function findTypeByName($name)
    {

        // Avoid MySQL duplicate entry on consecutive checks without flushing.
        if (array_key_exists($name, $this->inMemoryEvents)) {
            return $this->inMemoryEvents[$name];
        }

        $className = $this->getClassResolver()->resolveClassName('Event\Entity\EventInterface');
        $event     = $this->getObjectManager()->getRepository($className)->findOneBy(['name' => $name]);
        /* @var $event Entity\EventInterface */

        if (!is_object($event)) {
            $event = new $className();
            $event->setName($name);
            $this->getObjectManager()->persist($event);
            $this->inMemoryEvents[$name] = $event;
        }

        return $event;
    }

    public function getEvent($id)
    {
        $className = $this->getClassResolver()->resolveClassName('Event\Entity\EventLogInterface');
        $event     = $this->getObjectManager()->find($className, $id);
        if (!is_object($event)) {
            throw new Exception\EntityNotFoundException(sprintf('Could not find an Entity by the ID of `%d`', $id));
        }
        $this->assertGranted('event.log.get', $event);
        return $event;
    }

    public function findAll($page, $limit = 100)
    {
        $className = $this->getClassResolver()->resolveClassName('Event\Entity\EventLogInterface');
        $dql       = 'SELECT e FROM ' . $className . ' e ' . 'ORDER BY e.id DESC';
        $paginator = new DoctrinePaginatorFactory($this->objectManager);
        $paginator = $paginator->createPaginator($dql, $page, $limit);
        $paginator->setFilter($this->persistentEventLogFilterChain);
        return $paginator;
    }

    public function logEvent(
        $uri,
        InstanceInterface $instance,
        UuidInterface $uuid,
        array $parameters = []
    ) {
        $actor = $this->authorizationService->getIdentity();

        if ($actor === null) {
            throw new UnauthorizedException;
        }

        $className = $this->getClassResolver()->resolveClassName('Event\Entity\EventLogInterface');

        /* @var $log Entity\EventLogInterface */
        $log = new $className();

        $log->setEvent($this->findTypeByName($uri));

        $log->setObject($uuid);
        $log->setActor($actor);
        $log->setInstance($instance);

        foreach ($parameters as $parameter) {
            $this->addParameter($log, $parameter);
        }

        $this->getObjectManager()->persist($log);

        return $log;
    }

    /**
     * @param Entity\EventLogInterface $log
     * @param array                    $parameter
     * @throws Exception\RuntimeException
     * @return self
     */
    protected function addParameter(Entity\EventLogInterface $log, array $parameter)
    {
        if (!array_key_exists('value', $parameter)) {
            throw new Exception\RuntimeException(sprintf('No value given'));
        }
        if (!array_key_exists('name', $parameter)) {
            throw new Exception\RuntimeException(sprintf('No name given'));
        }
        if (!is_string($parameter['name'])) {
            throw new Exception\RuntimeException(sprintf(
                'Parameter name should be string, but got `%s`',
                gettype($parameter['name'])
            ));
        }

        /* @var $entity \Event\Entity\EventParameterInterface */
        $name   = $this->findParameterNameByName($parameter['name']);
        $entity = $this->getClassResolver()->resolve('Event\Entity\EventParameterInterface');

        $entity->setLog($log);
        $entity->setName($name);
        $entity->setValue($parameter['value']);
        $log->addParameter($entity);
        $this->getObjectManager()->persist($entity);
    }

    /**
     * @param string $name
     * @return \Event\Entity\EventParameterNameInterface
     */
    protected function findParameterNameByName($name)
    {

        // Avoid MySQL duplicate entry on consecutive checks without flushing.
        if (array_key_exists($name, $this->inMemoryParameterNames)) {
            return $this->inMemoryParameterNames[$name];
        }

        $className = $this->getClassResolver()->resolveClassName('Event\Entity\EventParameterNameInterface');
        /* @var $parameterName Entity\EventParameterNameInterface */
        $parameterName = $this->getObjectManager()->getRepository($className)->findOneBy(['name' => $name]);

        if (!is_object($parameterName)) {
            $parameterName = new $className();
            $parameterName->setName($name);
            $this->getObjectManager()->persist($parameterName);
            $this->inMemoryParameterNames[$name] = $parameterName;
        }

        return $parameterName;
    }
}
