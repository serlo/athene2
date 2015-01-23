<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace User\Entity;

use Authorization\Entity\ParametrizedPermissionInterface;
use Authorization\Entity\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * A role.
 *
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role implements RoleInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string") *
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="roles")
     * @ORM\JoinTable(name="role_user")
     */
    protected $users;

    /**
     * @ORM\ManyToMany(targetEntity="Permission", inversedBy="roles", indexBy="name")
     * @ORM\JoinTable(name="role_permission")
     */
    protected $permissions;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="parents")
     * @ORM\JoinTable(name="role_inheritance",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")}
     * )
     */
    protected $children;

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="children")
     */
    protected $parents;

    public function __construct()
    {
        $this->users       = new ArrayCollection();
        $this->permissions = new ArrayCollection();
        $this->children    = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function addChildren($children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    public function addChild(RoleInterface $child)
    {
        $this->children->add($child);
    }

    public function addPermission(ParametrizedPermissionInterface $permission)
    {
        $this->permissions->add($permission);
    }

    public function hasPermission($permission)
    {
        /* @var $instancePermission ParametrizedPermissionInterface */
        foreach ($this->getPermissions() as $instancePermission) {
            if ($permission instanceof ParametrizedPermissionInterface) {
                if ($instancePermission === $permission) {
                    return true;
                }
            } else {
                if ($instancePermission->getName() == $permission) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function hasChildren()
    {
        return !empty($this->children);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getId()
    {
        return $this->id;
    }

    public function addUser(UserInterface $user)
    {
        $this->users->add($user);
    }

    public function removeUser(UserInterface $user)
    {
        $this->users->removeElement($user);
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function removePermission(ParametrizedPermissionInterface $permission)
    {
        $this->permissions->removeElement($permission);
    }

    public function removeChild(RoleInterface $child)
    {
        $this->children->removeElement($child);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function removeChildren($children)
    {
        foreach ($children as $child) {
            $this->removeChild($child);
        }
    }
}
