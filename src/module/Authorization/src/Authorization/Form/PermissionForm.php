<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license      LGPL-3.0
 * @license      http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Authorization\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PermissionForm extends Form
{
    public function __construct($permissions, $instances)
    {
        parent::__construct('add-permission');
        $inputFilter = new InputFilter('article');

        $values = [];
        foreach ($permissions as $permission) {
            $values[$permission->getId()] = $permission->getName();
        }

        $this->add((new Select('permission'))->setLabel('Permission:')->setValueOptions($values));

        $values = [
            -1 => 'Global'
        ];
        foreach ($instances as $instance) {
            $values[$instance->getId()] = $instance->getName();
        }

        $this->add((new Select('instance'))->setLabel('Instance:')->setValueOptions($values));

        $this->add(
            (new Submit('submit'))->setValue('Add')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'     => 'permission',
                'required' => true
            ]
        );

        $this->setInputFilter($inputFilter);
    }
}
