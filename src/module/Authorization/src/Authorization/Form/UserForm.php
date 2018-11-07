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
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class UserForm extends Form
{
    public function __construct()
    {
        parent::__construct('add-user');
        $this->add(new CsrfToken('csrf'));

        $inputFilter = new InputFilter('article');

        $this->add((new Text('user'))->setLabel('Username:'));

        $this->add(
            (new Submit('submit'))->setValue('Add')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'     => 'user',
                'required' => true,
            ]
        );

        $this->setInputFilter($inputFilter);
    }
}
