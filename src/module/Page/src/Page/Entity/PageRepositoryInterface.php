<?php
namespace Page\Entity;

use Authorization\Entity\RoleInterface;
use Doctrine\Common\Collections\Collection;
use Instance\Entity\InstanceAwareInterface;
use License\Entity\LicenseAwareInterface;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Uuid\Entity\UuidInterface;
use Versioning\Entity\RepositoryInterface;

interface PageRepositoryInterface
    extends RepositoryInterface, LicenseAwareInterface, InstanceAwareInterface, UuidInterface,
            TaxonomyTermAwareInterface
{
    /**
     * @return RoleInterface[]|Collection
     */
    public function getRoles();

    /**
     * @param RoleInterface $role
     * @return void
     */
    public function addRole(RoleInterface $role);

    /**
     * @return TaxonomyTermInterface
     */
    public function getForum();

    /**
     * @param TaxonomyTermInterface|null $forum
     * @return void
     */
    public function setForum(TaxonomyTermInterface $forum = null);
}
