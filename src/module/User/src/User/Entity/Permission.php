<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace User\Entity;

use Authorization\Entity\ParametrizedPermissionInterface;
use Authorization\Entity\PermissionInterface;
use Authorization\Entity\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="instance_permission")
 */
class Permission implements ParametrizedPermissionInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="permissions")
     * @ORM\JoinTable(name="role_permission")
     */
    protected $roles;

    /**
     * @ORM\ManyToOne(targetEntity="PermissionKey",inversedBy="parametrizedPermissions")
     * @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     */
    protected $permission;

    /**
     * @ORM\ManyToOne(targetEntity="Instance\Entity\Instance")
     * @ORM\JoinColumn(name="instance_id", referencedColumnName="id", nullable=true)
     */
    protected $instance;

    public function __toString()
    {
        return $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->permission->getName();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getParameter($key)
    {
        if ($key == 'instance') {
            return $this->instance;
        }

        return null;
    }

    /**
     * @return PermissionInterface
     */
    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission(PermissionInterface $permission)
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
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public function setParameter($key, $value)
    {
        if ($key === 'instance') {
            $this->instance = $value;
        }
    }
}
