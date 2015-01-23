<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification;

use ClassResolver\ClassResolverAwareTrait;
use Common\Traits\FlushableTrait;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

class SubscriptionManager implements SubscriptionManagerInterface
{
    use ObjectManagerAwareTrait, ClassResolverAwareTrait, FlushableTrait;

    public function findSubscriptionsByUser(UserInterface $user)
    {
        $className     = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $criteria      = ['user' => $user->getId()];
        $subscriptions = $this->getObjectManager()->getRepository($className)->findBy($criteria);
        $collection    = new ArrayCollection($subscriptions);
        return $collection;
    }

    public function findSubscriptionsByUuid(UuidInterface $uuid)
    {
        $className     = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $criteria      = ['object' => $uuid->getId()];
        $subscriptions = $this->getObjectManager()->getRepository($className)->findBy($criteria);
        $collection    = new ArrayCollection($subscriptions);
        return $collection;
    }

    public function update(UserInterface $user, UuidInterface $object, $email)
    {
        $className    = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $criteria     = [
            'user'   => $user->getId(),
            'object' => $object->getId()
        ];
        $subscription = $this->getObjectManager()->getRepository($className)->findOneBy($criteria);

        $subscription->setNotifyMailman((bool)$email);
        $this->objectManager->persist($subscription);
    }

    public function findSubscription(UserInterface $user, UuidInterface $object)
    {
        $className    = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $criteria     = [
            'user'   => $user->getId(),
            'object' => $object->getId()
        ];
        $subscription = $this->getObjectManager()->getRepository($className)->findOneBy($criteria);
        return $subscription;
    }

    public function isUserSubscribed(UserInterface $user, UuidInterface $object)
    {
        $className    = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $criteria     = [
            'user'   => $user->getId(),
            'object' => $object->getId()
        ];
        $subscription = $this->getObjectManager()->getRepository($className)->findOneBy($criteria);
        return is_object($subscription);
    }

    public function unSubscribe(UserInterface $user, UuidInterface $object)
    {
        $className    = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $criteria     = [
            'user'   => $user->getId(),
            'object' => $object->getId()
        ];
        $subscription = $this->getObjectManager()->getRepository($className)->findOneBy($criteria);

        if (is_object($subscription)) {
            $this->objectManager->remove($subscription);
        }
    }

    public function subscribe(UserInterface $user, UuidInterface $object, $notifyMailman)
    {
        if (!$this->isUserSubscribed($user, $object)) {
            $class = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
            /* @var $entity \Notification\Entity\SubscriptionInterface */
            $entity = new $class();
            $entity->setSubscriber($user);
            $entity->setSubscribedObject($object);
            $entity->setNotifyMailman($notifyMailman);
            $this->getObjectManager()->persist($entity);
        }
    }

    public function hasSubscriptions()
    {
        $className     = $this->getClassResolver()->resolveClassName('Notification\Entity\SubscriptionInterface');
        $subscriptions = $this->getObjectManager()->getRepository($className)->findBy([], null, 1);
        return count($subscriptions) > 0;
    }
}
