<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Csrf;

class MoveForm extends Form
{

    function __construct()
    {
        parent::__construct('move');
        $this->add(new Csrf('entity_move_csrf'));

        $this->setAttribute('method', 'post');
        $filter = new InputFilter();
        $this->setInputFilter($filter);

        $this->add(
            [
                'name'       => 'to',
                'attributes' => [
                    'type'        => 'text',
                    'tabindex'    => 1,
                    'placeholder' => 'ID (e.g.: 123)'
                ],
                'options'    => [
                    'label' => 'Move to: '
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'submit',
                'attributes' => [
                    'type'     => 'submit',
                    'value'    => 'Move',
                    'tabindex' => 2,
                    'class'    => 'btn btn-success pull-right'
                ]
            ]
        );

        $filter->add(
            [
                'name'       => 'to',
                'required'   => true,
                'validators' => [
                    [
                        'name' => 'int'
                    ],
                ]
            ]
        );
    }
}
