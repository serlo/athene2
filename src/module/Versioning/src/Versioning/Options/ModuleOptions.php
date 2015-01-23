<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Versioning\Options;

use Versioning\Exception;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $permissions = [];

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

    public function getPermission($repository, $action)
    {
        $className = get_class($repository);

        if (!isset($this->permissions[$className])) {
            throw new Exception\RuntimeException(sprintf('Permission for repository "%s" not found', $className));
        }

        if (!isset($this->permissions[$className][$action])) {
            throw new Exception\RuntimeException(sprintf(
                'Permission action "%s" for object "%s" not found',
                $action,
                $className
            ));
        }

        return $this->permissions[$className][$action];
    }
}
