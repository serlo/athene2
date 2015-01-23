<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment ORM Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="context_route")
 */
class Route implements RouteInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="route_name")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Context", inversedBy="routes")
     */
    protected $context;

    /**
     * @ORM\OneToMany(targetEntity="RouteParameter", mappedBy="route", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $parameters;

    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    public function addParameter($key, $value)
    {
        $parameter = new RouteParameter();
        $parameter->setKey($key);
        $parameter->setValue($value);
        $parameter->setRoute($this);
        $this->parameters->add($parameter);
    }

    public function addParameters(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (!empty($value)) {
                $this->addParameter($key, $value);
            }
        }
    }

    public function getContext()
    {
        return $this->context;
    }

    public function setContext(ContextInterface $context)
    {
        $this->context = $context;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getInstance()
    {
        return $this->getContext()->getInstance();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
