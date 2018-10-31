<?php
/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Term\Form;

use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

class TermFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('term');

        $this->add((new Text('name'))->setAttribute('id', 'term[name]')->setLabel('Name:'));
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags',
                    ],
                ],
                'validators' => [
                    [
                        'name'    => 'NotEmpty',
                        'options' => [
                            'messages' => [
                                NotEmpty::IS_EMPTY => 'The title can\'t be empty',
                            ],
                        ],
                    ],
                    [
                        'name'    => 'Regex',
                        'options' => [
                            'pattern' => '~^[a-zA-Z\-_ 0-9äöüÄÖÜß,\:\.]*$~',
                            'messages' => [
                                Regex::NOT_MATCH => 'Title should not contain special characters',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
