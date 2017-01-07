<?php
/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class SettingsForm extends Form
{
    public function __construct($entityManager, $dontValidate = false)
    {
        parent::__construct('settings');
        $this->add(new Csrf('user_settings_csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $filter = new InputFilter();
        $this->setInputFilter($filter);

        $this->add((new Email('email'))->setAttribute('id', 'email')->setLabel('Email:'));
        $this->add((new Textarea('description'))->setAttribute('id', 'description')->setLabel('About me:'));

        $this->add((new Submit('submit'))->setValue('Update')
            ->setAttribute('class', 'btn btn-success pull-right'));

        if (!$dontValidate) {
            $filter->add([
                'name' => 'email',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'EmailAddress'
                    ],
                    [
                        'name' => 'User\Validator\UniqueUser',
                        'options' => [
                            'object_repository' => $entityManager->getRepository('User\Entity\User'),
                            'fields' => ['email'],
                            'object_manager' => $entityManager
                        ]
                    ]
                ]
            ]);
        }
    }
}
