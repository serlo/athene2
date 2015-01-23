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
namespace Authorization\Entity;

use Rbac\Role\HierarchicalRoleInterface;
use User\Entity\UserInterface;

interface RoleInterface extends HierarchicalRoleInterface
{
    /**
     * @param RoleInterface $child
     * @return void
     */
    public function addChild(RoleInterface $child);

    /**
     * @param RoleInterface[] $children
     * @return void
     */
    public function addChildren($children);

    /**
     * @param RoleInterface[] $children
     * @return void
     */
    public function removeChildren($children);

    /**
     * @param ParametrizedPermissionInterface $permission
     * @return void
     */
    public function addPermission(ParametrizedPermissionInterface $permission);

    /**
     * @param UserInterface $user
     * @return void
     */
    public function addUser(UserInterface $user);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return ParametrizedPermissionInterface[]
     */
    public function getPermissions();

    /**
     * @return UserInterface[]
     */
    public function getUsers();

    /**
     * @param RoleInterface $child
     * @return mixed
     */
    public function removeChild(RoleInterface $child);

    /**
     * @param ParametrizedPermissionInterface $permission
     * @return mixed
     */
    public function removePermission(ParametrizedPermissionInterface $permission);

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function removeUser(UserInterface $user);

    /**
     * @param string $name
     * @return mixed
     */
    public function setName($name);
}
