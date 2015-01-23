<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\Entity\EntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="term_taxonomy_entity")
 */
class TaxonomyTermEntity implements TaxonomyTermNodeInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     * targetEntity="TaxonomyTerm",
     * inversedBy="termTaxonomyEntity",
     * cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="term_taxonomy_id", referencedColumnName="id", nullable=false)
     */
    protected $termTaxonomy;

    /**
     * @ORM\ManyToOne(
     * targetEntity="Entity\Entity\Entity",
     * inversedBy="termTaxonomyEntity",
     * cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", nullable=false)
     */
    protected $entity;

    /**
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    public function __construct(TaxonomyTermInterface $termTaxonomy, EntityInterface $entity)
    {
        $this->setTaxonomyTerm($termTaxonomy);
        $this->setObject($entity);
        $this->setPosition(0);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTaxonomyTerm()
    {
        return $this->termTaxonomy;
    }

    public function getObject()
    {
        return $this->entity;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setTaxonomyTerm(TaxonomyTermInterface $termTaxonomy)
    {
        $this->termTaxonomy = $termTaxonomy;
        return $this;
    }

    public function setObject(TaxonomyTermAwareInterface $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}
