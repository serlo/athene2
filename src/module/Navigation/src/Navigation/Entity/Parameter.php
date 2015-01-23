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
namespace Navigation\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use Instance\Entity\InstanceInterface;
use Type\Entity\TypeAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="navigation_parameter")
 */
class Parameter implements ParameterInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="parameters")
     * @var PageInterface
     */
    protected $page;

    /**
     * @ORM\OneToMany(targetEntity="Parameter", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Parameter", inversedBy="children")
     */
    protected $parent;

    /**
     * @ORM\ManyToOne(targetEntity="ParameterKey")
     */
    protected $key;

    /**
     * @ORM\Column(type="string")
     */
    protected $value;

    public function __construct()
    {
        $this->children = new ArrayCollection;
    }

    /**
     * @param ParameterInterface $child
     * @return void
     */
    public function addChild(ParameterInterface $child)
    {
        $this->children->add($child);
    }

    /**
     * @return self[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return InstanceInterface
     */
    public function getInstance()
    {
        return $this->page->getInstance();
    }

    /**
     * @return ParameterKeyInterface
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param ParameterKeyInterface $key
     * @return void
     */
    public function setKey(ParameterKeyInterface $key)
    {
        $this->key = $key;
    }

    /**
     * @return PageInterface
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param PageInterface $page
     * @return void
     */
    public function setPage(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * @return ParameterInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ParameterInterface $parent
     * @return void
     */
    public function setParent(ParameterInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return $this->children->count() > 0;
    }

    /**
     * @param ParameterInterface $child
     * @return void
     */
    public function removeChild(ParameterInterface $child)
    {
        $this->children->removeElement($child);
    }
}
