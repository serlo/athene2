<?php


namespace Page\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Page\Entity\PageRepositoryInterface;
use Taxonomy\Manager\TaxonomyManagerInterface;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RepositoryForm extends Form
{

    public function __construct(ObjectManager $objectManager, PageRepositoryInterface $pageRepository, TaxonomyManagerInterface $taxonomyManager)
    {
        parent::__construct('createPage');

        $hydrator = new DoctrineObject($objectManager);
        $filter   = new InputFilter();

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setInputFilter($filter);
        $this->setHydrator($hydrator);
        $this->setObject($pageRepository);

        $this->add((new Text('slug'))->setLabel('Url:'));
        $this->add((new Text('forum'))->setLabel('Forum Id:')->setAttribute('placeholder', '123'));

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
            array(
                'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
                'name'    => 'license',
                'options' => array(
                    'object_manager' => $objectManager,
                    'label'          => 'License',
                    'target_class'   => 'License\Entity\License',
                    'property'       => 'title'
                )
            )
        );

        $this->add(
            array(
                'type'    => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
                'name'    => 'roles',
                'options' => array(
                    'object_manager' => $objectManager,
                    'label'          => 'Roles',
                    'target_class'   => 'User\Entity\Role',
                )
            )
        );

        $this->add((new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right'));

        $filter->add(
            [

                'name'       => 'forum',
                'required'   => false,
                'validators' => [
                    [
                        'name'    => 'Taxonomy\Validator\ValidAssociation',
                        'options' => [
                            'target'           => $this,
                            'taxonomy_manager' => $taxonomyManager
                        ]
                    ]
                ]
            ]
        );
    }
}
