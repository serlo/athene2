<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\Options;

use Uuid\Exception;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @var array
     */
    protected $defaultPermissions = [
        'trash' => 'uuid.trash',
        'restore' => 'uuid.restore',
        'purge' => 'uuid.purge'
    ];

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param string $object
     * @param string $action
     * @return string
     * @throws Exception\RuntimeException
     */
    public function getPermission($scope, $action)
    {
        $scope = (string) $scope;
        if (!isset($this->permissions[$scope])) {
            $permissions = $this->defaultPermissions;
        } else {
            $permissions = $this->permissions[$scope];
        }

        if (!isset($permissions[$action])) {
            throw new Exception\RuntimeException(sprintf(
                'Permission action "%s" for scope "%s" not found',
                $action,
                $scope
            ));
        }

        return $permissions[$action];
    }
}
