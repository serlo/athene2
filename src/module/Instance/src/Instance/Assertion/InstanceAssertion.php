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
namespace Instance\Assertion;

use Authorization\Service\AuthorizationService as StatefulAuthorizationService;
use Authorization\Service\PermissionServiceAwareTrait;
use Instance\Entity\InstanceAwareInterface;
use Instance\Exception\InvalidArgumentException;
use ZfcRbac\Assertion\AssertionInterface;
use ZfcRbac\Service\AuthorizationService;

class InstanceAssertion implements AssertionInterface
{
    use PermissionServiceAwareTrait;

    /**
     * Check if this assertion is true
     *
     * @param  AuthorizationService $authorization
     * @param  mixed                $context
     * @throws InvalidArgumentException
     * @return bool
     */
    public function assert(AuthorizationService $authorization, $context = null)
    {
        if (!$context instanceof InstanceAwareInterface) {
            throw new InvalidArgumentException();
        }
        if (!$authorization instanceof StatefulAuthorizationService) {
            throw new InvalidArgumentException();
        }
        $result            = $authorization->getAuthorizationResult();
        $permission        = $result->getPermission();
        $permissionToMatch = $this->getPermissionService()->findParametrizedPermission(
            (string)$permission,
            'instance',
            $context->getInstance()->getId()
        );

        foreach ($result->getRoles() as $role) {
            if ($role->hasPermission($permissionToMatch->getId())) {
                return true;
            }
        }

        return false;
    }
}
