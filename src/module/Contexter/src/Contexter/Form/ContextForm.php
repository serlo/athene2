<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ContextForm extends Form
{

    public function __construct(array $parameters, array $types)
    {
        parent::__construct('context');
        $inputFilter = new InputFilter();

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $this->setInputFilter($inputFilter);

        $values = [];
        foreach ($types as $type) {
            $values[$type] = $type;
        }

        $this->add(['name' => 'route', 'type' => 'Hidden',]);
        $this->add((new Select('type'))->setLabel('Select a type:')->setValueOptions($values));
        $this->add((new Text('title'))->setLabel('Title:'));
        $this->add((new Text('object'))->setLabel('Object-ID:'));
        $this->add(new ParameterFieldset($parameters));
        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'       => 'title',
                'required'   => true,
                'filters'    => [
                    [
                        'name' => 'StripTags'
                    ]
                ],
                'validators' => [
                    [
                        'name'    => 'Regex',
                        'options' => [
                            'pattern' => '~^[a-zA-Z\- 0-9üöäÜÖÄ!]+$~'
                        ]
                    ]
                ]

            ]
        );

        $inputFilter->add(
            [
                'name'        => 'object',
                'required'    => true,
                'allow_empty' => false,
                'validators'  => [
                    [
                        'name' => 'NotEmpty'
                    ],
                    [
                        'name' => 'Digits'
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'type',
                'required'   => true,
                'validators' => [
                    [
                        'name'    => 'Regex',
                        'options' => [
                            'pattern' => '~^[a-zA-Z]*$~'
                        ]
                    ]
                ]
            ]
        );
    }
}
