<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Flag\Form;

use Doctrine\Common\Collections\Collection;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class FlagForm extends Form
{

    public function __construct(Collection $types)
    {
        parent::__construct('context');
        $this->add(new Csrf('flag_csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $inputFilter = new InputFilter('context');
        $this->setInputFilter($inputFilter);

        $values = [];
        /* @var $type \Flag\Entity\TypeInterface */
        foreach ($types as $type) {
            $values[$type->getId()] = $type->getName();
        }

        $this->add(
            (new Select('type'))->setLabel('Type:')->setOptions(
                [
                    'value_options' => $values
                ]
            )
        );

        $this->add((new Textarea('content'))->setLabel('Content:'));

        $this->add(
            (new Submit('submit'))->setValue('Report')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'     => 'content',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'type',
                'required' => true
            ]
        );
    }
}
