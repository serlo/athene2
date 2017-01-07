<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity\Form;

use License\Entity\LicenseInterface;
use License\Form\AgreementFieldset;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ModulePageForm extends Form
{

    function __construct(LicenseInterface $license)
    {
        parent::__construct('course-page');
        $this->add(new Csrf('entity_module_page_csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');


        $this->add((new Text('title'))->setAttribute('id', 'title')->setLabel('Title:'));
        $select = new Select('icon');
        $select->setLabel('Select an icon');
        $select->setAttribute('id', 'icon');
        $select->setValueOptions(array(
                'explanation' => 'Explanation',
                'play' => 'Video',
                'question' => 'Exercises'
            ));
        $this->add($select);
        $this->add((new Textarea('content'))->setAttribute('id', 'content')->setLabel('Content:'));
        $this->add(
            (new Textarea('changes'))->setAttribute('id', 'changes')->setLabel('Changes:')->setAttribute(
                'class',
                'plain'
            )
        );
        $this->add(new AgreementFieldset($license));
        $this->add(new Controls());

        $inputFilter = new InputFilter('course-page');
        $inputFilter->add(['name' => 'title', 'required' => true, 'filters' => [['name' => 'StripTags']]]);
        $inputFilter->add(['name' => 'content', 'required' => true]);
        $inputFilter->add(['name' => 'changes', 'required' => false, 'filters' => [['name' => 'StripTags']]]);
        $this->setInputFilter($inputFilter);
    }
}
