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

use Doctrine\Common\Collections\Collection;
use DateTime;
use Instance\Entity\InstanceAwareInterface;
use License\Entity\LicenseAwareInterface;
use Link\Entity\LinkableInterface;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use Type\Entity\TypeAwareInterface;
use Uuid\Entity\UuidInterface;
use Versioning\Entity\RepositoryInterface;
use Doctrine\Common\Collections\Collection;

interface EntityInterface
    extends UuidInterface, InstanceAwareInterface, RepositoryInterface, LinkableInterface, LicenseAwareInterface,
            TaxonomyTermAwareInterface, TypeAwareInterface
{

    /**
     * @return DateTime
     */
    public function getTimestamp();

    /**
     * @param DateTime $date
     */
    public function setTimestamp(DateTime $date);

    /**
     * Returns the children
     *
     * @param string $linkType
     * @param string $childType
     * @return Collection|EntityInterface[]
     */
    public function getChildren($linkType, $childType = null);

    /**
     * Returns the parents
     *
     * @param string $linkyType
     * @param string $parentType
     * @return Collection|EntityInterface[]
     */
    public function getParents($linkyType, $parentType = null);

    /**
     * Returns the entity following the given entity or null
     *
     * @param EntityInterface $previous
     * @return EntityInterface|null
     */
    public function getNextValidSibling($linkType, EntityInterface $previous);

    /**
     * Returns the previous valid sibling or null
     *
     * @param EntityInterface $following
     * @return EntityInterface|null
     */
    public function getPreviousValidSibling($linkType, EntityInterface $following);

    /**
     * @return bool
     */
    public function isUnrevised();

    /**
     * @return RevisionInterface
     */
    public function getHead();

    /**
     * @return int
     */
    public function countUnrevised();
}
