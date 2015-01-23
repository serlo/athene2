<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\UserInterface;
use Uuid\Entity\Uuid;
use Versioning\Entity\RepositoryInterface;

/**
 * An entity link.
 *
 * @ORM\Entity
 * @ORM\Table(name="entity_revision")
 */
class Revision extends Uuid implements RevisionInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Entity", inversedBy="revisions")
     */
    protected $repository;

    /**
     * @ORM\OneToMany(targetEntity="RevisionField", mappedBy="revision", cascade={"persist"})
     */
    protected $fields;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     */
    protected $author;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $date;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    public function delete()
    {
        return $this;
    }

    public function get($field, $default = null)
    {
        $field = $this->getField($field);

        if (!is_object($field)) {
            return $default;
        }

        return $field->getValue();
    }

    protected function getField($field)
    {
        $expression = Criteria::expr()->eq("name", $field);
        $criteria   = Criteria::create()->where($expression)->setFirstResult(0)->setMaxResults(1);
        $data       = $this->fields->matching($criteria);

        if (empty($data)) {
            return null;
        }

        return $data[0];
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getTimestamp()
    {
        return $this->date;
    }

    public function set($name, $value)
    {
        $entity = $this->getField($name);

        if (!is_object($entity)) {
            $entity = new RevisionField($name, $this->getId());
            $this->fields->add($entity);
        }

        $entity->setName($name);
        $entity->setRevision($this);
        $entity->setValue($value);

        return $entity;
    }

    public function setTimestamp(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getInstance()
    {
        return $this->getRepository()->getInstance();
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
