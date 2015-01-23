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
namespace Navigation\Form;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as ObjectHydrator;
use Navigation\Manager\NavigationManagerInterface;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ContainerForm extends Form
{
    public function __construct(EntityManager $entityManager, NavigationManagerInterface $navigationManager)
    {
        parent::__construct('container');

        $hydrator = new ObjectHydrator($entityManager);
        $filter   = new InputFilter();
        $types    = [];

        foreach ($navigationManager->getTypes() as $type) {
            $types[$type->getId()] = $type->getName();
        }

        $this->setHydrator($hydrator);
        $this->setInputFilter($filter);

        $this->add(
            (new Select('type'))->setLabel('Type:')->setOptions(
                [
                    'value_options' => $types
                ]
            )
        );
        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'instance',
                'options' => [
                    'object_manager' => $entityManager,
                    'target_class'   => 'Navigation\Entity\Container'
                ]
            ]
        );

        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right')
        );

        $filter->add(
            [
                'name'     => 'type',
                'required' => true
            ]
        );

        $filter->add(
            [
                'name'     => 'instance',
                'required' => true
            ]
        );
    }
}
