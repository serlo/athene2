<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Discussion\Form;

use Common\Form\Element\CsrfToken;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Notification\Form\OptInHiddenFieldset;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\InputFilter\InputFilter;

class CommentForm extends AbstractForm
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('comment');
        $this->add(new CsrfToken('csrf'));
        $hydrator    = new DoctrineObject($objectManager);
        $inputFilter = new InputFilter('comment');

        $this->setHydrator($hydrator);
        $this->setInputFilter($inputFilter);
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'author',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'User\Entity\User',
                ],
            ]
        );
        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'parent',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'Discussion\Entity\Comment',
                ],
            ]
        );
        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'instance',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'Instance\Entity\Instance',
                ],
            ]
        );


        $this->add(new OptInHiddenFieldset());

        $this->add(
            (new Textarea('content'))
                ->setAttribute('placeholder', t('Your response'))
                ->setAttribute('class', 'discussion-content autosize')
                ->setAttribute('rows', 1)
        );
        $this->add(
            (new Submit('start'))->setValue(t('Reply'))->setAttribute('class', 'btn btn-success pull-right discussion-submit')
        );


        $inputFilter->add(['name' => 'content', 'required' => true]);
        $inputFilter->add(['name' => 'instance', 'required' => true]);
        $inputFilter->add(['name' => 'author', 'required' => true]);
        $inputFilter->add(['name' => 'parent', 'required' => true]);
    }
}
