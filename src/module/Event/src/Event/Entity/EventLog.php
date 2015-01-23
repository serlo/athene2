<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_log")
 */
class EventLog implements EventLogInterface
{
    use InstanceAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="actor_id", referencedColumnName="id")
     */
    protected $actor;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="Uuid\Entity\Uuid")
     * @ORM\JoinColumn(name="uuid_id", referencedColumnName="id")
     */
    protected $uuid;

    /**
     * @ORM\OneToMany(targetEntity="EventParameter", mappedBy="log")
     */
    protected $parameters;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getParameter($name)
    {
        foreach ($this->getParameters() as $parameter) {
            if ($parameter->getName() == $name) {
                if ($parameter instanceof EventParameterUuid) {
                    return $parameter->getValue();
                } else {
                    return $parameter->getValue();
                }
            }
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getActor()
    {
        return $this->actor;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getName()
    {
        return $this->getEvent()->getName();
    }

    public function getObject()
    {
        return $this->uuid;
    }

    public function getTimestamp()
    {
        return $this->date;
    }

    public function setActor(UserInterface $actor)
    {
        $this->actor = $actor;
    }

    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
    }

    public function setObject(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function addParameter(EventParameterInterface $parameter)
    {
        $this->parameters->add($parameter);
    }
}
