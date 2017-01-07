<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Blog\Form;

use Common\Hydrator\HydratorPluginAwareDoctrineObject;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Element\Date;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CreatePostForm extends Form
{

    function __construct(ObjectManager $objectManager, HydratorPluginAwareDoctrineObject $hydrator)
    {
        parent::__construct('post');
        $this->add(new Csrf('blog_create_post_csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $inputFilter = new InputFilter('post');

        $this->setInputFilter($inputFilter);
        $this->setHydrator($hydrator);

        $this->add(
            [
                'type'    => 'Common\Form\Element\ObjectHidden',
                'name'    => 'blog',
                'options' => [
                    'object_manager' => $objectManager,
                    'target_class'   => 'Taxonomy\Entity\TaxonomyTerm'
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
            (new Date('publish'))->setAttribute('id', 'publish')->setAttribute('class', 'datepicker')->setAttribute(
                'type',
                'text'
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
                'name'     => 'blog',
                'required' => true
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'instance',
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
