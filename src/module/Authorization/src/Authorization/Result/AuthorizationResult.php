<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Result;

use Authorization\Service\AuthorizationService;
use Rbac\Role\RoleInterface;
use ZfcRbac\Identity\IdentityInterface;

class AuthorizationResult
{
    /**
     * @var string
     */
    protected $permission;

    /**
     * @var IdentityInterface|null
     */
    protected $identity;

    /**
     * @var RoleInterface[]
     */
    protected $roles = [];

    /**
     * @var AuthorizationService
     */
    protected $authorizationService;

    /**
     * @param AuthorizationService $authorizationService
     */
    public function setAuthorizationService(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    /**
     * @return AuthorizationService
     */
    public function getAuthorizationService()
    {
        return $this->authorizationService;
    }

    /**
     * @return null|IdentityInterface
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param null|IdentityInterface $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return RoleInterface[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param RoleInterface[] $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
}
