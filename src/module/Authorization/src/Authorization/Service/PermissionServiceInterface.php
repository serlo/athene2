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
namespace Authorization\Service;

use Authorization\Entity\ParametrizedPermissionInterface;
use Authorization\Entity\PermissionInterface;
use Authorization\Exception\PermissionNotFoundException;

interface PermissionServiceInterface
{
    /**
     * @return PermissionInterface[]
     */
    public function findAllPermissions();

    /**
     * @param $name
     * @param $parameterKey
     * @param $parameterValue
     * @return PermissionInterface
     */
    public function findOrCreateParametrizedPermission($name, $parameterKey, $parameterValue);

    /**
     * @param PermissionInterface|string $name
     * @param string                     $parameterKey
     * @param mixed                      $parameterValue
     * @throws PermissionNotFoundException
     * @return PermissionInterface
     */
    public function findParametrizedPermission($name, $parameterKey, $parameterValue);

    /**
     * @param PermissionInterface|string $name
     * @param string                     $parameterKey
     * @param mixed                      $parameterValue
     * @return PermissionInterface[]
     */
    public function findParametrizedPermissions($name, $parameterKey, $parameterValue);

    /**
     * @param string $name
     * @return PermissionInterface
     */
    public function findPermissionByName($name);

    /**
     * @param int $id
     * @return ParametrizedPermissionInterface
     */
    public function getParametrizedPermission($id);

    /**
     * @param int $id
     * @return PermissionInterface
     */
    public function getPermission($id);
}
