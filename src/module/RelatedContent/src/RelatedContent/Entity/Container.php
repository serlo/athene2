<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use Instance\Entity\InstanceInterface;
use Uuid\Entity\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="related_content_container")
 */
class Container implements ContainerInterface
{
    use InstanceAwareTrait;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Uuid\Entity\Uuid")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Holder",
     * mappedBy="container")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $holders;

    public function __construct(UuidInterface $id, InstanceInterface $instance)
    {
        $this->id                = $id;
        $this->holders           = new ArrayCollection();
        $this->internalRelations = new ArrayCollection();
        $this->instance          = $instance;
    }

    public function getId()
    {
        return $this->id->getId();
    }

    public function getHolders()
    {
        return $this->holders;
    }

    public function addHolder(HolderInterface $holder)
    {
        $this->holders->add($holder);
    }

    public function getObject()
    {
        return $this->id;
    }
}
