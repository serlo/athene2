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

use Instance\Entity\InstanceProviderInterface;

interface PageInterface extends InstanceProviderInterface
{
    /**
     * @param PageInterface $page
     * @return void
     */
    public function addChild(PageInterface $page);

    /**
     * @param ParameterInterface $parameter
     * @return void
     */
    public function addParameter(ParameterInterface $parameter);

    /**
     * @return PageInterface[]
     */
    public function getChildren();

    /**
     * @return ContainerInterface
     */
    public function getContainer();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return ParameterInterface[]
     */
    public function getParameters();

    /**
     * @return PageInterface
     */
    public function getParent();

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @return bool
     */
    public function hasChildren();

    /**
     * @param PageInterface $page
     * @return void
     */
    public function removeChild(PageInterface $page);

    /**
     * @param ParameterInterface $parameter
     * @return mixed
     */
    public function removeParameter(ParameterInterface $parameter);

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container);

    /**
     * @param PageInterface $page
     * @return PageInterface
     */
    public function setParent(PageInterface $page);

    /**
     * @param $position
     * @return void
     */
    public function setPosition($position);
}
