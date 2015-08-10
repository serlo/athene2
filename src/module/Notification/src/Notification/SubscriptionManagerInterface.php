<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification;

use Common\ObjectManager\Flushable;
use Notification\Entity\SubscriptionInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

interface SubscriptionManagerInterface extends Flushable
{

    /**
     * @param UuidInterface $uuid
     * @return SubscriptionInterface[]
     */
    public function findSubscriptionsByUuid(UuidInterface $uuid);

    /**
     * @param UserInterface $user
     * @param UuidInterface $object
     * @return SubscriptionInterface
     */
    public function findSubscription(UserInterface $user, UuidInterface $object);

    /**
     * @param UserInterface $user
     * @return SubscriptionInterface[]
     */
    public function findSubscriptionsByUser(UserInterface $user);

    /**
     * @return bool
     */
    public function hasSubscriptions();

    /**
     * @param UserInterface $user
     * @param UuidInterface $object
     * @return bool
     */
    public function isUserSubscribed(UserInterface $user, UuidInterface $object);

    /**
     * @param UserInterface $user
     * @param UuidInterface $object
     * @param bool          $notifyMailman
     * @return void
     */
    public function update(UserInterface $user, UuidInterface $object, $notifyMailman);

    /**
     * @param UserInterface $user
     * @param UuidInterface $object
     * @param bool          $notifyMailman
     * @return void
     */
    public function subscribe(UserInterface $user, UuidInterface $object, $notifyMailman);

    /**
     * @param UserInterface $user
     * @param UuidInterface $object
     * @return void
     */
    public function unSubscribe(UserInterface $user, UuidInterface $object);
}
