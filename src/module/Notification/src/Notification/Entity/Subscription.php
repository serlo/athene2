<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Notification\Entity;

use Doctrine\ORM\Mapping as ORM;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscription")
 */
class Subscription implements SubscriptionInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Uuid\Entity\Uuid")
     * @ORM\JoinColumn(name="uuid_id", referencedColumnName="id")
     */
    protected $object;

    /**
     * @ORM\OneToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", name="notify_mailman")
     */
    protected $notifyMailman;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    public function getNotifyMailman()
    {
        return $this->notifyMailman;
    }

    public function setNotifyMailman($notifyMailman)
    {
        $this->notifyMailman = (bool) $notifyMailman;
    }

    public function setSubscriber(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getSubscriber()
    {
        return $this->user;
    }

    public function setSubscribedObject(UuidInterface $uuid)
    {
        $this->object = $uuid;
    }

    public function getSubscribedObject()
    {
        return $this->object;
    }

    public function getTimestamp()
    {
        return $this->date;
    }
}
