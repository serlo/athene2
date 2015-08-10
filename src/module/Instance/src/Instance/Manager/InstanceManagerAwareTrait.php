<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Instance\Manager;

trait InstanceManagerAwareTrait
{
    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    /**
     * @return InstanceManagerInterface $instanceManager
     */
    public function getInstanceManager()
    {
        return $this->instanceManager;
    }

    /**
     * @param InstanceManagerInterface $tenantManager
     * @return void
     */
    public function setInstanceManager(InstanceManagerInterface $tenantManager)
    {
        $this->instanceManager = $tenantManager;
    }
}
