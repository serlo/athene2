<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Mvc\I18n\Translator;
use Doctrine\ORM\EntityManager;

class Register extends Form
{

    public function __construct(EntityManager $entityManager, Translator $translator)
    {
        parent::__construct('signUp');
        $this->add(new Csrf('user_sign_up_csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $filter = new RegisterFilter($entityManager);
        $this->setInputFilter($filter);


        $this->add((new Text('username'))
            ->setLabel('Username:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Enter username'))
        );

        $this->add((new Text('email'))
            ->setAttribute('type', 'email')
            ->setLabel('Email:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Enter email address'))
        );
        $this->add((new Text('emailConfirm'))
            ->setAttribute('type', 'email')
            ->setLabel('Confirm email:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Confirm email address'))
        );

        $this->add((new Password('password'))
            ->setLabel('Password:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Enter password'))
        );
        $this->add((new Password('passwordConfirm'))
            ->setLabel('Confirm password:')
            ->setAttribute('required', 'required')
            ->setAttribute('placeholder', $translator->translate('Confirm password'))
        );

        $this->add((new Submit('submit'))
            ->setValue('Sign up')
            ->setAttribute('class', 'btn btn-success pull-right')
        );
    }
}
