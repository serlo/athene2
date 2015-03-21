<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Form;

use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Login extends Form
{

    public function __construct($translator)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $filter = new InputFilter();
        $this->setInputFilter($filter);

        $this->add((new Text('email'))
            ->setAttribute('type', 'email')
            ->setLabel('Email address:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Email address:'))
        );
        $this->add((new Password('password'))
            ->setLabel('Password:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Password:'))
        );
        $this->add((new Checkbox('remember'))
            ->setLabel('Remember me')
            ->setChecked(true)
        );

        $this->add((new Submit('submit'))
            ->setValue('Login')
            ->setAttribute('class', 'btn btn-success pull-right')
        );

        $filter->add(
            [
                'name'     => 'email',
                'required' => true
            ]
        );

        $filter->add(
            [
                'name'     => 'password',
                'required' => true
            ]
        );
    }
}
