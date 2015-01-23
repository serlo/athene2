<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class AdPageForm extends Form
{

    public function __construct()
    {
        parent::__construct('set About Ad Page');
        $this->setAttribute('class', 'clearfix');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        
        $this->add((new Text('id'))->setLabel('Page ID:'))
            ->setAttribute('required', 'required');
        $this->add((new Submit('submit'))->setValue('Save')
            ->setAttribute('class', 'btn btn-success pull-right'));
    }
}
