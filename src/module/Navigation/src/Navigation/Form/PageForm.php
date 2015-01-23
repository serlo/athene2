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
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PageForm extends Form
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('pageForm');

        $filter   = new InputFilter();
        $hydrator = new ObjectHydrator($entityManager);

        $this->setHydrator($hydrator);
        $this->setInputFilter($filter);

        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'container',
                'options' => [
                    'object_manager' => $entityManager,
                    'target_class'   => 'Navigation\Entity\Container'
                ]
            ]
        );

        $this->add(
            [
                'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
                'name'    => 'parent',
                'options' => [
                    'label'              => 'Parent:',
                    'object_manager'     => $entityManager,
                    'target_class'       => 'Navigation\Entity\Page',
                    'property'           => 'id',
                    'display_empty_item' => true,
                    'empty_item_label'   => '---',
                ],
            ]
        );

        $this->add((new Text('position'))->setLabel('Position'));

        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-default')
        );

        $filter->add(
            [
                'name'     => 'container',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int'],
                ],
            ]
        );

        $filter->add(
            [
                'name'     => 'parent',
                'required' => false,
                'filters'  => [
                    ['name' => 'Int'],
                ],
            ]
        );

        $filter->add(
            [
                'name'     => 'position',
                'required' => false,
                'filters'  => [
                    ['name' => 'Int'],
                ],
            ]
        );
    }
}
