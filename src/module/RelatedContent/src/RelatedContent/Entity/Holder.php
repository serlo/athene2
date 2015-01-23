<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="related_content")
 */
class Holder implements HolderInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Container", inversedBy="externalRelations")
     */
    protected $container;

    /**
     * @ORM\OneToOne(targetEntity="External", mappedBy="id")
     */
    protected $external;

    /**
     * @ORM\OneToOne(targetEntity="Internal", mappedBy="id")
     */
    protected $internal;

    /**
     * @ORM\OneToOne(targetEntity="Category", mappedBy="id")
     */
    protected $category;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position;

    public function getPosition()
    {
        return $this->position;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getSpecific()
    {
        $keys = [
            'internal',
            'external',
            'category'
        ];
        foreach ($keys as $key) {
            if (is_object($this->$key)) {
                return $this->$key;
            }
        }
        return NULL;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}
