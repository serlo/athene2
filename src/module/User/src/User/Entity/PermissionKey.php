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
namespace User\Entity;

use Authorization\Entity\PermissionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * A role.
 *
 * @ORM\Entity
 * @ORM\Table(name="permission")
 */
class PermissionKey implements PermissionInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="PermissionKey",mappedBy="permission")
     */
    protected $parametrizedPermissions;

    public function __construct()
    {
        $this->parametrizedPermissions = new ArrayCollection();
    }

    /**
     * @return \Authorization\Entity\ParametrizedPermissionInterface[]|ArrayCollection
     */
    public function getParametrizedPermissions()
    {
        return $this->parametrizedPermissions;
    }

    /**
     * @return \Authorization\Entity\ParametrizedPermissionInterface[]|ArrayCollection
     */
    public function getRoles()
    {
        $return = new ArrayCollection();
        foreach ($this->getParametrizedPermissions() as $permission) {
            foreach ($permission->getRoles() as $role) {
                if (!$return->contains($role)) {
                    $return->add($role->getRoles());
                }
            }
        }

        return $return;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
