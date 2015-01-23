<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Service;

use Authorization\Assertion\AssertionInterface;
use Authorization\Result\AuthorizationResult;
use ZfcRbac\Exception;

class AuthorizationService extends \ZfcRbac\Service\AuthorizationService
{
    /**
     * @param \Rbac\Permission\PermissionInterface|string $permission
     * @param null                                        $context
     * @return bool
     */
    public function isGranted($permission, $context = null)
    {
        $roles = $this->roleService->getIdentityRoles();

        $result = $this->createResult($permission, $roles);

        if (empty($roles)) {
            return false;
        }

        if (!$this->rbac->isGranted($roles, $permission)) {
            return false;
        }

        if ($this->hasAssertion($permission)) {
            return $this->assertStrategy($this->assertions[$permission], $result, $context);
        }

        return true;
    }

    /**
     * @param  string|callable|AssertionInterface $assertion
     * @param  mixed                              $context
     * @param  AuthorizationResult                $result
     * @return bool
     * @throws Exception\InvalidArgumentException If an invalid assertion is passed
     */
    protected function assertStrategy($assertion, AuthorizationResult $result, $context = null)
    {
        if (is_callable($assertion)) {
            return $assertion($result, $context);
        } elseif ($assertion instanceof AssertionInterface) {
            return $assertion->assert($result, $context);
        } elseif (is_string($assertion)) {
            $assertion = $this->assertionPluginManager->get($assertion);

            return $assertion->assert($result, $context);
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Assertion must be callable, string or implement Authorization\Assertion\AssertionInterface, "%s" given',
            is_object($assertion) ? get_class($assertion) : gettype($assertion)
        ));
    }

    /**
     * @param string $permission
     * @param array  $roles
     * @return AuthorizationResult
     */
    protected function createResult($permission, $roles)
    {
        $result = new AuthorizationResult();
        $result->setPermission($permission);
        $result->setIdentity($this->getIdentity());
        $result->setRoles($roles);
        $result->setAuthorizationService($this);

        return $result;
    }
}
