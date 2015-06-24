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
use Entity\Exception;
use Instance\Entity\InstanceAwareTrait;
use License\Entity\LicenseInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Entity\TaxonomyTermNodeInterface;
use Type\Entity\TypeAwareTrait;
use Uuid\Entity\Uuid;
use Versioning\Entity\RevisionInterface;

/**
 * An entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="entity")
 */
class Entity extends Uuid implements EntityInterface
{
    use TypeAwareTrait;
    use InstanceAwareTrait;

    /**
     * @ORM\OneToMany(targetEntity="EntityLink", mappedBy="child", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"order" = "ASC"})
     */
    protected $parentLinks;

    /**
     * @ORM\OneToMany(targetEntity="EntityLink", mappedBy="parent", cascade={"persist", "remove"},
     * orphanRemoval=true)
     * @ORM\OrderBy({"order" = "ASC"})
     */
    protected $childLinks;

    /**
     * @ORM\OneToMany(targetEntity="Revision", mappedBy="repository", cascade={"remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $revisions;

    /**
     * @ORM\OneToOne(targetEntity="Revision")
     * @ORM\JoinColumn(name="current_revision_id", referencedColumnName="id")
     */
    protected $currentRevision;

    /**
     * @ORM\OneToMany(targetEntity="Taxonomy\Entity\TaxonomyTermEntity", mappedBy="entity", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $termTaxonomyEntities;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="License\Entity\LicenseInterface")
     */
    protected $license;

    public function __construct()
    {
        $this->revisions            = new ArrayCollection();
        $this->childLinks           = new ArrayCollection();
        $this->parentLinks          = new ArrayCollection();
        $this->children             = new ArrayCollection();
        $this->parents              = new ArrayCollection();
        $this->issues               = new ArrayCollection();
        $this->terms                = new ArrayCollection();
        $this->termTaxonomyEntities = new ArrayCollection();
    }

    public function addRevision(RevisionInterface $revision)
    {
        $this->revisions->add($revision);
    }

    public function addTaxonomyTerm(TaxonomyTermInterface $taxonomyTerm, TaxonomyTermNodeInterface $node = null)
    {
        if ($node === null) {
            throw new Exception\InvalidArgumentException('Missing parameter node');
        }
        $this->termTaxonomyEntities->add($node);
    }

    public function countUnrevised()
    {
        $current = $this->getCurrentRevision() ? $this->getCurrentRevision()->getId() : 0;

        return $this->revisions->matching(
            Criteria::create()->where(Criteria::expr()->gt('id', $current))->andWhere(
                    Criteria::expr()->eq('trashed', false)
                )
        )->count();
    }

    public function createLink()
    {
        return new EntityLink();
    }

    public function createRevision()
    {
        $revision = new Revision();
        $revision->setRepository($this);

        return $revision;
    }

    public function getChildLinks()
    {
        return $this->childLinks;
    }

    public function getChildren($linkyType, $childType = null)
    {
        $collection = new ArrayCollection();

        foreach ($this->getChildLinks() as $link) {
            $childTypeName = $link->getChild()->getType()->getName();
            if ($link->getType()->getName(
                ) === $linkyType && ($childType === null || ($childType !== null && $childTypeName === $childType))
            ) {
                $collection->add($link->getChild());
            }
        }

        return $collection;
    }

    public function getCurrentRevision()
    {
        return $this->currentRevision;
    }

    public function setCurrentRevision(RevisionInterface $currentRevision)
    {
        $this->currentRevision = $currentRevision;
    }

    public function getHead()
    {
        return $this->revisions->first();
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function setLicense(LicenseInterface $license)
    {
        $this->license = $license;
    }

    public function getParentLinks()
    {
        return $this->parentLinks;
    }

    public function getParents($linkType, $parentType = null)
    {
        $collection = new ArrayCollection();

        foreach ($this->getParentLinks() as $link) {
            $childTypeName = $link->getChild()->getType()->getName();
            if ($link->getType()->getName(
                ) === $linkType && ($parentType === null || ($parentType !== null && $childTypeName === $parentType))
            ) {
                $collection->add($link->getParent());
            }
        }

        return $collection;
    }

    public function getNextValidSibling($linkType, EntityInterface $previous)
    {
        $children = $this->getChildren($linkType, $previous->getType());

        // Checks if the given entity is a child at all
        if (($index = $children->indexOf($previous)) == false) {
            return null;
        }

        for ($i = $index+1; $i < $children->count(); ++$i) {
            $child = $children->get($i);
            if ($child->hasCurrentRevision() && !$child->isTrahsed()) {
                return $child;
            }
        }

        return null;
    }

    public function getPreviousValidSibling($linkType, EntityInterface $following)
    {
        $children = $this->getChildren($linkType, $following->getType());

        if (($index = $children->indexOf($following)) == false) {
            return null;
        }

        for ($i = $index-1; $i >= 0; --$i) {
            $child = $children->get($i);
            if ($child->hasCurrentRevision() && !$child->isTrahsed()) {
                return $child;
            }
        }

        return null;
    }

    public function getRevisions()
    {
        return $this->revisions;
    }

    public function getTaxonomyTerms()
    {
        $collection = new ArrayCollection();

        foreach ($this->termTaxonomyEntities as $rel) {
            $collection->add($rel->getTaxonomyTerm());
        }

        return $collection;
    }

    public function getTimestamp()
    {
        return $this->date;
    }

    public function hasCurrentRevision()
    {
        return is_object($this->getCurrentRevision());
    }

    public function isUnrevised()
    {
        return $this->countUnrevised() > 0;
    }

    public function removeRevision(RevisionInterface $revision)
    {
        $this->revisions->removeElement($revision);
    }

    public function removeTaxonomyTerm(TaxonomyTermInterface $taxonomyTerm, TaxonomyTermNodeInterface $node = null)
    {
        if ($node === null) {
            throw new Exception\InvalidArgumentException('Missing parameter node');
        }
        $this->termTaxonomyEntities->removeElement($node);
    }

    public function setTimestamp(\DateTime $date)
    {
        $this->date = $date;
    }
}
