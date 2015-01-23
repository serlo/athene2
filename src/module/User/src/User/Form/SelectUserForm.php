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
namespace User\Form;

use Zend\Form\Element\Email;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class SelectUserForm extends Form
{

    public function __construct()
    {
        parent::__construct('select-user');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $filter = new InputFilter();
        $this->setInputFilter($filter);
        
        $this->add((new Email('email'))->setLabel('Email:'));
        
        $this->add((new Submit('submit'))->setValue('Restore')
            ->setAttribute('class', 'btn btn-success pull-right'));
        
        $filter->add([
            'name' => 'email',
            'required' => true
        ]);
    }
}
