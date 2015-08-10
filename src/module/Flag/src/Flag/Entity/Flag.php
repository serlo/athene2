<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Flag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="flag")
 */
class Flag implements FlagInterface
{
    use\Type\Entity\TypeAwareTrait;
    use InstanceAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Uuid\Entity\Uuid", inversedBy="flags")
     * @ORM\JoinColumn(name="uuid_id", referencedColumnName="id")
     */
    protected $object;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     */
    protected $reporter;

    /**
     * @ORM\Column(type="string")
     */
    protected $content;

    /**
     * @ORM\Column(type="datetime", name="`timestamp`", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $timestamp;

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setObject(UuidInterface $object)
    {
        $this->object = $object;

        return $this;
    }

    public function getReporter()
    {
        return $this->reporter;
    }

    public function setReporter(UserInterface $reporter)
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
