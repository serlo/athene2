<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Authorization\Form;

use Common\Form\Element\CsrfToken;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PermissionForm extends Form
{
    public function __construct($permissions, $instances)
    {
        parent::__construct('add-permission');
        $this->add(new CsrfToken('csrf'));

        $inputFilter = new InputFilter('article');

        $values = [];
        foreach ($permissions as $permission) {
            $values[$permission->getId()] = $permission->getName();
        }

        $this->add((new Select('permission'))->setLabel('Permission:')->setValueOptions($values));

        $values = [
            -1 => 'Global',
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
                'required' => true,
            ]
        );

        $this->setInputFilter($inputFilter);
    }
}
