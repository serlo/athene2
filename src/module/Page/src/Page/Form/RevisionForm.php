<?php
namespace Page\Form;

use License\Entity\LicenseInterface;
use License\Form\AgreementFieldset;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RevisionForm extends Form
{
    public function __construct(LicenseInterface $license)
    {
        parent::__construct('createRepository');
        $filter = new InputFilter();

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setInputFilter($filter);

        $text = new Text('title');
        $text->setLabel('Title:')->setAttribute('required', 'required')->setAttribute('id', 'title');
        $this->add($text);

        $textarea = new Textarea('content');
        $textarea->setLabel('Content:')->setAttribute('required', 'required')->setAttribute('id', 'content');
        $this->add($textarea);

        $this->add(new AgreementFieldset($license));

        $submit = new Submit('submit');
        $submit->setValue('Save')->setAttribute('class', 'btn btn-success pull-right');
        $this->add($submit);
    }
}
