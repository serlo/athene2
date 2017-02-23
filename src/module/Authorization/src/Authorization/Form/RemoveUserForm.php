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

use Zend\Form\Element\Submit;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RemoveUserForm extends Form
{
    function __construct($username)
    {
        parent::__construct('remove-user');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'pull-right');

        $this->add(new Csrf('authorization_remove_user_csrf_' . $username));

        $inputFilter = new InputFilter('article');
        $this->add((new Hidden('user'))->setValue($username));
        $this->add(
            (new Submit('submit'))->setValue('Remove')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'     => 'user',
                'required' => true
            ]
        );
        $this->setInputFilter($inputFilter);
    }
}