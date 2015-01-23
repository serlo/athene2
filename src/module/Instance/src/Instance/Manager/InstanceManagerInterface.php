<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Instance\Manager;

use Doctrine\Common\Collections\Collection;
use Instance\Entity\InstanceInterface;

interface InstanceManagerInterface
{

    /**
     * @return Collection|InstanceInterface[]
     */
    public function findAllInstances();

    /**
     * @param string $name
     * @return InstanceInterface
     */
    public function findInstanceByName($name);

    /**
     * @param string $subDomain
     * @return InstanceInterface
     */
    public function findInstanceBySubDomain($subDomain);

    /**
     * @return InstanceInterface
     */
    public function getDefaultInstance();

    /**
     * @param int $id
     * @return InstanceInterface
     */
    public function getInstance($id);

    /**
     * @return InstanceInterface
     */
    public function getInstanceFromRequest();

    /**
     * @param int|InstanceInterface $id
     * @return void
     */
    public function switchInstance($id);
}
