<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Entity;

use Rbac\Permission\PermissionInterface as RbacPermissionInterface;

interface ParametrizedPermissionInterface extends RbacPermissionInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $key
     * @return mixed
     */
    public function getParameter($key);

    /**
     * @return PermissionInterface
     */
    public function getPermission();

    /**
     * @return RoleInterface[]
     */
    public function getRoles();

    /**
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public function setParameter($key, $value);

    /**
     * @param PermissionInterface $permission
     * @return void
     */
    public function setPermission(PermissionInterface $permission);
}
