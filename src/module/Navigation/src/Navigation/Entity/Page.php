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
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use Instance\Entity\InstanceInterface;
use Type\Entity\TypeAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="navigation_page")
 */
class Page implements PageInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Container", inversedBy="pages")
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     * @ORM\OrderBy({"position" = "ASC"})
     * @var PageInterface[]|Collection
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @var PageInterface
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Parameter", mappedBy="page")
     * @var ParameterInterface[]|Collection
     */
    protected $parameters;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $position;

    public function __construct()
    {
        $this->children   = new ArrayCollection;
        $this->parameters = new ArrayCollection;
    }

    /**
     * @param PageInterface $page
     * @return void
     */
    public function addChild(PageInterface $page)
    {
        $this->children->add($page);
    }

    /**
     * @param ParameterInterface $parameter
     * @return void
     */
    public function addParameter(ParameterInterface $parameter)
    {
        $this->parameters->add($parameter);
    }

    /**
     * @return PageInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
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
        return $this->container->getInstance();
    }

    /**
     * @return ParameterInterface[]
     */
    public function getParameters()
    {
        return $this->parameters->matching(Criteria::create()->where(Criteria::expr()->isNull('parent')));
    }

    /**
     * @return PageInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param PageInterface $page
     * @return PageInterface
     */
    public function setParent(PageInterface $page)
    {
        $this->parent = $page;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return (int)$this->position;
    }

    /**
     * @param $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return $this->children->count() > 0;
    }

    /**
     * @param PageInterface $page
     * @return void
     */
    public function removeChild(PageInterface $page)
    {
        $this->children->removeElement($page);
    }

    /**
     * @param ParameterInterface $parameter
     * @return mixed
     */
    public function removeParameter(ParameterInterface $parameter)
    {
        $this->parameters->removeElement($parameter);
    }
}
