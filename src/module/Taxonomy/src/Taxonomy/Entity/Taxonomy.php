<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;

/**
 * A Taxonomy.
 *
 * @ORM\Entity
 * @ORM\Table(name="taxonomy")
 */
class Taxonomy implements TaxonomyInterface
{
    use \Type\Entity\TypeAwareTrait;
    use InstanceAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="TaxonomyTerm", mappedBy="taxonomy")
     * @ORM\OrderBy({"weight" = "ASC"})
     */
    protected $terms;

    public function __construct()
    {
        $this->terms = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTerms()
    {
        return $this->terms;
    }

    public function addTerm($term)
    {
        $this->getTerms()->add($term);
    }

    public function getName()
    {
        return $this->getType()->getName();
    }

    public function getChildren()
    {
        $collection = new ArrayCollection();
        $terms      = $this->getTerms();
        foreach ($terms as $entity) {
            if (!$entity->hasParent() || ($entity->hasParent() && $entity->getParent()->getTaxonomy() !== $this)) {
                $collection->add($entity);
            }
        }
        return $collection;
    }
}
