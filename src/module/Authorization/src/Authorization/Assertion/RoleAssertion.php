<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license      LGPL-3.0
 * @license      http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Authorization\Assertion;

use Authorization\Entity\RoleInterface;
use Authorization\Exception\InvalidArgumentException;
use Authorization\Exception\PermissionNotFoundException;
use Authorization\Result\AuthorizationResult;
use Authorization\Service\PermissionServiceAwareTrait;
use Authorization\Service\PermissionServiceInterface;
use Authorization\Service\RoleServiceAwareTrait;
use Instance\Manager\InstanceManagerAwareTrait;
use Instance\Manager\InstanceManagerInterface;
use Rbac\Traversal\Strategy\TraversalStrategyInterface;

class RoleAssertion implements AssertionInterface
{
    use PermissionServiceAwareTrait, InstanceManagerAwareTrait;

    /**
     * @var TraversalStrategyInterface
     */
    protected $traversalStrategy;

    public function __construct(
        InstanceManagerInterface $instanceManager,
        PermissionServiceInterface $permissionService,
        TraversalStrategyInterface $traversalStrategy
    ) {
        $this->permissionService = $permissionService;
        $this->instanceManager   = $instanceManager;
        $this->traversalStrategy = $traversalStrategy;
    }

    public function assert(AuthorizationResult $result, $role = null)
    {
        if (!$role instanceof RoleInterface) {
            throw new InvalidArgumentException;
        }

        $instanceManager   = $this->getInstanceManager();
        $permissionService = $this->getPermissionService();
        $assertion         = new InstanceAssertion($instanceManager, $permissionService, $this->traversalStrategy);
        $checkPermission   = $result->getPermission() . '.' . $role->getName();
        $result            = clone $result;
        $instancesToCheck  = [];
        $rolesToCheck      = $assertion->flattenRoles([$role]);

        foreach ($rolesToCheck as $roleToCheck) {
            foreach ($roleToCheck->getPermissions() as $permission) {
                $instance = $permission->getParameter('instance');
                if(!in_array($instance, $instancesToCheck)){
                    $instancesToCheck[] = $instance;
                }
            }
        }

        try {
            $this->getPermissionService()->findPermissionByName($checkPermission);
        } catch (PermissionNotFoundException $e) {
            $checkPermission = $result->getPermission();
        }

        $result->setPermission($checkPermission);

        foreach ($instancesToCheck as $instance) {
            if (!$assertion->assert($result, $instance)) {
                return false;
            }
        }

        return true;
    }
}
