<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Manager;

use Common\ObjectManager\Flushable;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
use Entity\Entity\RevisionInterface;
use Instance\Entity\InstanceInterface;

interface EntityManagerInterface extends Flushable
{

    /**
     * @param string            $type
     * @param array             $data
     * @param InstanceInterface $instance
     * @return EntityInterface
     */
    public function createEntity($type, array $data = [], InstanceInterface $instance);

    /**
     * @param bool $bypassInstanceIsolation
     * @return EntityInterface[]|Collection
     */
    public function findAll($bypassInstanceIsolation = false);

    /**
     * @param string $name
     * @param bool   $bypassInstanceIsolation
     * @return EntityInterface[]|Collection
     */
    public function findEntitiesByTypeName($name, $bypassInstanceIsolation = false);

    /**
     *  Finds all unrevised Entities
     *
     *  @return RevisionInterface[]|Collection
     */
    public function findAllUnrevisedRevisions();

    /**
     * @param int $id
     * @return EntityInterface
     */
    public function getEntity($id);
}
