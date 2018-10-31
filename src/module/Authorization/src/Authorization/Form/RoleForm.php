<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Form;

use Common\Form\Element\CsrfToken;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RoleForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('role');
        $this->add(new CsrfToken('csrf'));

        $inputFilter = new InputFilter();

        $this->setInputFilter($inputFilter);
        $this->setHydrator(new DoctrineHydrator($objectManager));

        $this->add(
            [
                'type'    => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
                'name'    => 'children',
                'options' => [
                    'label'          => 'Inherits permissions from (be very careful!):',
                    'object_manager' => $objectManager,
                    'target_class'   => 'User\Entity\Role',
                    'property'       => 'name',
                ],
            ]
        );

        $this->add((new Text('name'))->setLabel('Name:'));

        $this->add(
            (new Submit('submit'))->setValue('Add')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'     => 'name',
                'required' => true,
            ]
        );
        $inputFilter->add(
            [
                'name'     => 'children',
                'required' => false,
            ]
        );
    }
}
