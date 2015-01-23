<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Entity;

interface RouteParameterInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getKey();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @return RouteInterface
     */
    public function getRoute();

    /**
     * @param string $key
     * @return self
     */
    public function setKey($key);

    /**
     * @param string $value
     * @return self
     */
    public function setValue($value);

    /**
     * @param RouteInterface $route
     * @return self
     */
    public function setRoute(RouteInterface $route);
}
