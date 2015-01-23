<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CategoryForm extends Form
{
    function __construct()
    {
        parent::__construct('category');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $inputFilter = new InputFilter('category');
        $this->setInputFilter($inputFilter);
        
        $this->add((new Text('title'))->setLabel('Title:'));
        
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
    }
}
