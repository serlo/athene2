<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Manager;

use Common\ObjectManager\Flushable;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
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
     * @param int $id
     * @return EntityInterface
     */
    public function getEntity($id);
}
