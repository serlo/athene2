<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Authorization\Service;

use Authorization\Entity\PermissionInterface;
use Common\ObjectManager\Flushable;
use Rbac\Role\RoleInterface;
use User\Entity\UserInterface;
use Zend\Form\FormInterface;

interface RoleServiceInterface extends Flushable
{
    /**
     * @param FormInterface $form
     * @return RoleInterface
     */
    public function createRole(FormInterface $form);

    /**
     * @return RoleInterface[]
     */
    public function findAllRoles();

    /**
     * @param $name
     * @return RoleInterface
     */
    public function findRoleByName($name);

    /**
     * @param int $id
     * @return RoleInterface
     */
    public function getRole($id);

    /**
     * @param int|RoleInterface $role
     * @param int|UserInterface $user
     * @return void
     */
    public function grantIdentityRole($role, $user);

    /**
     * @param int|RoleInterface       $role
     * @param int|PermissionInterface $permission
     * @return void
     */
    public function grantRolePermission($role, $permission);

    /**
     * @param int $role
     * @param int $user
     * @return void
     */
    public function removeIdentityRole($role, $user);

    /**
     * @param int $role
     * @param int $permission
     * @return void
     */
    public function removeRolePermission($role, $permission);
}
