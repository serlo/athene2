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
namespace Navigation\Manager;

use Common\ObjectManager\Flushable;
use Instance\Entity\InstanceInterface;
use Navigation\Entity\ContainerInterface;
use Navigation\Entity\PageInterface;
use Navigation\Entity\ParameterInterface;
use Navigation\Entity\ParameterKeyInterface;
use Navigation\Exception\ContainerNotFoundException;
use Type\Entity\TypeInterface;
use Zend\Form\FormInterface;

interface NavigationManagerInterface extends Flushable
{
    /**
     * @param FormInterface $form
     * @return ContainerInterface
     */
    public function createContainer(FormInterface $form);

    /**
     * @param FormInterface $form
     * @return PageInterface
     */
    public function createPage(FormInterface $form);

    /**
     * @param FormInterface $form
     * @return ParameterInterface
     */
    public function createParameter(FormInterface $form);

    /**
     * @param FormInterface $form
     * @return ParameterKeyInterface
     */
    public function createParameterKey(FormInterface $form);

    /**
     * @param string            $name
     * @param InstanceInterface $instance
     * @return ContainerInterface
     * @throws ContainerNotFoundException
     */
    public function findContainerByNameAndInstance($name, InstanceInterface $instance);

    /**
     * @param InstanceInterface $instance
     * @return ContainerInterface[]
     * @throws ContainerNotFoundException
     */
    public function findContainersByInstance(InstanceInterface $instance);

    /**
     * @param int $id
     * @throws ContainerNotFoundException
     * @return ContainerInterface
     * @throws ContainerNotFoundException
     */
    public function getContainer($id);

    /**
     * @param int $id
     * @return PageInterface
     * @throws PageNotFoundException
     */
    public function getPage($id);

    /**
     * @param int $id
     * @return ParameterInterface
     * @throws ParameterNotFoundException
     */
    public function getParameter($id);

    /**
     * @return ParameterKeyInterface[]
     */
    public function getParameterKeys();

    /**
     * @return TypeInterface[]
     */
    public function getTypes();

    /**
     * @param int $id
     * @return void
     * @throws ContainerNotFoundException
     */
    public function removeContainer($id);

    /**
     * @param int $id
     * @return void
     */
    public function removePage($id);

    /**
     * @param int $id
     * @return void
     */
    public function removeParameter($id);

    /**
     * @param FormInterface $form
     * @return void
     */
    public function updatePage(FormInterface $form);

    /**
     * @param FormInterface $form
     * @return void
     */
    public function updateParameter(FormInterface $form);
}
