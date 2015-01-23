<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Blog\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Element\Date;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class UpdatePostForm extends Form
{

    function __construct(ObjectManager $objectManager)
    {
        parent::__construct('post');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $hydrator    = new DoctrineHydrator($objectManager);
        $inputFilter = new InputFilter('post');

        $this->setInputFilter($inputFilter);
        $this->setHydrator($hydrator);

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

        $this->add((new Text('title'))->setAttribute('id', 'title')->setLabel('Title:'));
        $this->add((new Textarea('content'))->setAttribute('id', 'content')->setLabel('Content:'));
        $this->add(
            (new Date('publish'))->setAttribute('id', 'publish')->setAttribute('type', 'text')->setAttribute(
                'class',
                'datepicker'
            )->setLabel('Publish date:')
        );
        $this->add((new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right'));

        $inputFilter->add(
            [
                'name'       => 'title',
                'required'   => true,
                'filters'    => [
                    [
                        'name' => 'StripTags'
                    ]
                ],
                'validators' => [
                    [
                        'name'    => 'Regex',
                        'options' => [
                            'pattern' => '~^[a-zA-Z\-_ 0-9äöüÄÖÜß/&\.\,\!\?]+$~'
                        ]
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'author',
                'required' => true
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'content',
                'required' => true
            ]
        );
    }
}
