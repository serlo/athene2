<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Entity;

use Doctrine\Common\Collections\Collection;
use Instance\Entity\InstanceAwareInterface;
use Uuid\Entity\UuidInterface;

interface ContainerInterface extends InstanceAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return Collection
     */
    public function getHolders();

    /**
     * @param HolderInterface $holder
     * @return self
     */
    public function addHolder(HolderInterface $holder);

    /**
     * @return UuidInterface
     */
    public function getObject();
}
