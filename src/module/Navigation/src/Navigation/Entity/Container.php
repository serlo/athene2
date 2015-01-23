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
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use Type\Entity\TypeAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="navigation_container")
 */
class Container implements ContainerInterface
{
    use InstanceAwareTrait, TypeAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="container")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection;
    }

    /**
     * @param PageInterface $page
     * @return void
     */
    public function removePage(PageInterface $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * @param PageInterface $page
     * @return void
     */
    public function addPage(PageInterface $page)
    {
        $this->pages->add($page);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return PageInterface[]
     */
    public function getPages()
    {
        return $this->pages->matching(
            Criteria::create()->where(Criteria::expr()->isNull('parent'))->orderBy(['position' => 'asc'])
        );
    }
}
