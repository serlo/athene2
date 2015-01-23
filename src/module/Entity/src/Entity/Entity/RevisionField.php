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

use Doctrine\ORM\Mapping as ORM;

/**
 * An entity link.
 *
 * @ORM\Entity
 * @ORM\Table(name="entity_revision_field")
 */
class RevisionField
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Revision", inversedBy="fields")
     * @ORM\JoinColumn(name="entity_revision_id", referencedColumnName="id")
     */
    protected $revision;

    /**
     * @ORM\Column(type="string", name="field")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return RevisionInterface $entityRevisionId
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @return string $field
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param RevisionInterface $entityRevision
     */
    public function setRevision(RevisionInterface $entityRevision)
    {
        $this->revision = $entityRevision;
    }

    /**
     * @param string $field
     */
    public function setName($field)
    {
        $this->name = $field;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function __construct($revision, $field)
    {
        $this->revision = $revision;
        $this->name     = $field;
    }
}
