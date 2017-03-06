<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Form;

use Common\Form\Element\CsrfToken;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class InternalForm extends Form
{

    function __construct()
    {
        parent::__construct('internal');
        $this->add(new CsrfToken('csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $inputFilter = new InputFilter('external');
        $this->setInputFilter($inputFilter);
        
        $this->add((new Text('title'))->setLabel('Title:'));
        $this->add((new Text('reference'))->setLabel('Reference:'));
        
        $this->add((new Submit('submit'))->setValue('Add')
            ->setAttribute('class', 'btn btn-success pull-right'));
        
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                [
                    'name' => 'StripTags'
                ]
            ]
        ]);
        
        $inputFilter->add([
            'name' => 'reference',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Digits'
                ]
            ]
        ]);
    }
}
