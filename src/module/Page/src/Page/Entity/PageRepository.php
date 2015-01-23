<?php
namespace Page\Entity;

use Authorization\Entity\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use License\Entity\LicenseInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Entity\TaxonomyTermNodeInterface;
use Uuid\Entity\Uuid;
use Versioning\Entity\RevisionInterface;

/**
 * A page repository.
 *
 * @ORM\Entity
 * @ORM\Table(name="page_repository")
 */
class PageRepository extends Uuid implements PageRepositoryInterface
{
    use InstanceAwareTrait;

    /**
     * @ORM\ManyToMany(targetEntity="User\Entity\Role")
     * @ORM\JoinTable(name="page_repository_role",
     *      joinColumns={@ORM\JoinColumn(name="page_repository_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    protected $roles;

    /**
     * @ORM\OneToOne(targetEntity="PageRevision")
     * @ORM\JoinColumn(name="current_revision_id", referencedColumnName="id")
     */
    protected $current_revision;

    /**
     * @ORM\OneToMany(targetEntity="PageRevision", mappedBy="page_repository",  cascade={"remove", "persist"}, orphanRemoval=true)
     */
    protected $revisions;

    /**
     * @ORM\ManyToOne(targetEntity="Taxonomy\Entity\TaxonomyTerm")
     * @ORM\JoinColumn(name="forum_id", referencedColumnName="id", nullable=true)
     */
    protected $forum;

    /**
     * @ORM\ManyToOne(targetEntity="License\Entity\LicenseInterface")
     */
    protected $license;

    public function __construct()
    {
        $this->revisions = new ArrayCollection();
        $this->roles     = new ArrayCollection();
    }

    public function addRevision(RevisionInterface $revision)
    {
        $this->revisions->add($revision);
        $revision->setRepository($this);
        return $revision;
    }

    public function addRole(RoleInterface $role)
    {
        $this->roles->add($role);
    }

    public function addRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->add($role);
        }
    }

    /**
     * @param TaxonomyTermInterface     $taxonomyTerm
     * @param TaxonomyTermNodeInterface $node
     * @return self
     */
    public function addTaxonomyTerm(TaxonomyTermInterface $taxonomyTerm, TaxonomyTermNodeInterface $node = null)
    {
        $this->setForum($taxonomyTerm);
    }

    public function createRevision()
    {
        $revision = new PageRevision();
        $revision->setRepository($this);
        return $revision;
    }

    public function getCurrentRevision()
    {
        return $this->current_revision;
    }

    public function setCurrentRevision(RevisionInterface $revision)
    {
        $this->current_revision = $revision;
    }

    public function getForum()
    {
        return $this->forum;
    }

    public function setForum(TaxonomyTermInterface $forum = null)
    {
        $this->forum = $forum;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function setLicense(LicenseInterface $license)
    {
        $this->license = $license;
    }

    public function getRevisions()
    {
        return $this->revisions;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(ArrayCollection $roles)
    {
        $this->roles->clear();
        $this->roles = $roles;
    }

    /**
     * @return TaxonomyTermInterface[]
     */
    public function getTaxonomyTerms()
    {
        return new ArrayCollection([$this->forum]);
    }

    public function hasCurrentRevision()
    {
        return $this->getCurrentRevision() !== null;
    }

    public function hasRole(RoleInterface $role)
    {
        return $this->roles->contains($role);
    }

    public function populate(array $data = [])
    {
        $this->injectFromArray('forum', $data);
        $this->injectFromArray('instance', $data);
        $this->injectFromArray('current_revision', $data);
    }

    public function removeRevision(RevisionInterface $revision)
    {
        if ($this->getCurrentRevision() == $revision) {
            $this->current_revision = null;
        }
        $this->revisions->removeElement($revision);
    }

    public function removeRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->removeElement($role);
        }
    }

    /**
     * @param TaxonomyTermInterface     $taxonomyTerm
     * @param TaxonomyTermNodeInterface $node
     * @return self
     */
    public function removeTaxonomyTerm(TaxonomyTermInterface $taxonomyTerm, TaxonomyTermNodeInterface $node = null)
    {
        $this->setForum(null);
    }

    private function injectFromArray($key, array $array, $default = null)
    {
        if (array_key_exists($key, $array)) {
            $this->$key = $array[$key];
        } elseif ($default !== null) {
            $this->$key = $default;
        }
    }
}
