<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Entity;

use DateTime;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

interface SubscriptionInterface
{

    /**
     * @return bool
     */
    public function getNotifyMailman();

    /**
     * @return UuidInterface
     */
    public function getSubscribedObject();

    /**
     * @return UserInterface
     */
    public function getSubscriber();

    /**
     * @return DateTime
     */
    public function getTimestamp();

    /**
     * @var bool
     * @return void
     */
    public function setNotifyMailman($notifyMailman);

    /**
     * @param UuidInterface $uuid
     * @return void
     */
    public function setSubscribedObject(UuidInterface $uuid);

    /**
     * @param UserInterface $user
     * @return void
     */
    public function setSubscriber(UserInterface $user);
}
