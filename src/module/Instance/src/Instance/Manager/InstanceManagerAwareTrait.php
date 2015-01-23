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
