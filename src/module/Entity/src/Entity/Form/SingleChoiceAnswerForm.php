<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity\Form;

use Common\Form\Element\CsrfToken;
use License\Entity\LicenseInterface;
use License\Form\AgreementFieldset;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class SingleChoiceAnswerForm extends Form
{
    public function __construct(LicenseInterface $license)
    {
        parent::__construct('single-choice-answer');
        $this->add(new CsrfToken('csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $this->add((new Textarea('content'))->setAttribute('id', 'content')->setLabel('Content:'));
        $this->add((new Textarea('feedback'))->setAttribute('id', 'feedback')->setLabel('Feedback:'));
        $this->add(
            (new Textarea('changes'))->setAttribute('id', 'changes')->setLabel('Changes:')->setAttribute(
                'class',
                'plain'
            )
        );
        $this->add(new AgreementFieldset($license));
        $this->add(new Controls());

        $inputFilter = new InputFilter('single-choice-answer');
        $inputFilter->add(['name' => 'content', 'required' => true]);
        $inputFilter->add(['name' => 'feedback', 'required' => false]);
        $inputFilter->add(['name' => 'changes', 'required' => false, 'filters' => [['name' => 'HtmlEntities']]]);
        $this->setInputFilter($inputFilter);
    }
}
