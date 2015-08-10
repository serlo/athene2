<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uuid\Entity\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_parameter")
 */
class EventParameter implements EventParameterInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventLog", inversedBy="parameters")
     */
    protected $log;

    /**
     * @ORM\ManyToOne(targetEntity="EventParameterName")
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="EventParameterUuid", mappedBy="eventParameter", cascade={"persist", "remove"})
     */
    protected $object;

    /**
     * @ORM\OneToOne(targetEntity="EventParameterString", mappedBy="eventParameter", cascade={"persist", "remove"})
     */
    protected $string;

    public function getId()
    {
        return $this->id;
    }

    public function getInstance()
    {
        return $this->log->getInstance();
    }

    public function getLog()
    {
        return $this->log;
    }

    public function setLog(EventLogInterface $log)
    {
        $this->log = $log;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(EventParameterNameInterface $name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        if (is_object($this->object)) {
            return $this->object->getValue();
        } elseif (is_object($this->string)) {
            return $this->string->getValue();
        }
        return null;
    }

    public function setValue($value)
    {
        if ($value instanceof UuidInterface) {
            $param        = new EventParameterUuid($this, $value);
            $this->object = $param;
        } else {
            $param        = new EventParameterString($this, $value);
            $this->string = $param;
        }
    }
}
