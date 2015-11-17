<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Discussion\Form;

use Common\Hydrator\HydratorPluginAwareDoctrineObject;
use Doctrine\Common\Persistence\ObjectManager;
use Notification\Form\OptInFieldset;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

class DiscussionForm extends AbstractForm
{

    function __construct(HydratorPluginAwareDoctrineObject $hydrator, ObjectManager $objectManager)
    {
        parent::__construct('discussion');
        $inputFilter = new InputFilter('discussion');

        $this->setInputFilter($inputFilter);
        $this->setHydrator($hydrator);
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'author',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'User\Entity\User'
                ]
            ]
        );
        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'object',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'Uuid\Entity\Uuid'
                ]
            ]
        );
        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'instance',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'Instance\Entity\Instance'
                ]
            ]
        );
        $this->add(new Hidden('terms'));
        $this->add(
            (new Text('title'))->setAttribute('placeholder', 'Title')
        );
        $this->add(
            (new Textarea('content'))->setAttribute(
            'placeholder',
                'Content'
            )
        );
        $this->add(new OptInFieldset());
        $this->add(
            (new Submit('start'))->setValue('Start discussion')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'       => 'title',
                'required'   => true,
                'filters'    => [['name' => 'StripTags']],
                'validators' => [
                    [
                        'name'    => 'Regex',
                        'options' => [
                            'pattern' => '~^[a-zA-Z\-_ 0-9äöüÄÖÜß,\:\.\?!]*$~',
                            'messages' => [
                                Regex::NOT_MATCH => 'Title should not contain special characters'
                            ]
                        ]
                    ]
                ]
            ]
        );
        $inputFilter->add(['name' => 'instance', 'required' => true]);
        $inputFilter->add(['name' => 'content', 'required' => true, 'filters' => [['name' => 'StripTags']]]);
    }
}
