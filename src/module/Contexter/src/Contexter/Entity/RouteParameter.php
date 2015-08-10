<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment ORM Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="context_route_parameter")
 */
class RouteParameter implements RouteParameterInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="`key`")
     */
    protected $key;

    /**
     * @ORM\Column(type="string", name="`value`")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Route", inversedBy="parameters")
     * @ORM\JoinColumn(name="context_route_id", referencedColumnName="id")
     */
    protected $route;

    public function getId()
    {
        return $this->id;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function setRoute(RouteInterface $route)
    {
        $this->route = $route;

        return $this;
    }
}
