<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Entity\Form;

use Common\Form\Element\CsrfToken;
use License\Entity\LicenseInterface;
use License\Form\AgreementFieldset;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Url;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

class AppletForm extends Form
{

    function __construct(LicenseInterface $license)
    {
        parent::__construct('applet');
        $this->add(new CsrfToken('csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $this->add((new Text('title'))->setAttribute('id', 'title')->setLabel('Title:'));
        $this->add((new Url('url'))->setAttribute('id', 'url')->setLabel('Applet Url:'));
        $this->add((new Textarea('content'))->setAttribute('id', 'content')->setLabel('Description:'));
        $this->add(
            (new Textarea('reasoning'))->setAttribute('id', 'reasoning')->setLabel('Reasoning:')
        );
        $this->add(
            (new Textarea('changes'))->setAttribute('id', 'changes')->setLabel('Changes:')->setAttribute(
                'class',
                'plain'
            )
        );
        $this->add((new Text('meta_title'))->setAttribute('id', 'meta_title')->setLabel('Search Engine Title:'));
        $this->add((new Text('meta_description'))->setAttribute('id', 'meta_description')->setLabel('Search Engine Description:'));
        $this->add(new AgreementFieldset($license));
        $this->add(new Controls());

        $inputFilter = new InputFilter('applet');
        $inputFilter->add(['name' => 'title', 'required' => true, 'filters' => [['name' => 'HtmlEntities']]]);
        $inputFilter->add(
            [
                'name' => 'url',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ]
                ],
                'validators' => [
                    [
                        'name'  => 'Regex',
                        'options' => [
                            'pattern' => '~^(https?:\/\/)?(.*?(geogebra\.org\/m\/.+|ggbm\.at\/.+))~',
                            'messages' => [
                                Regex::NOT_MATCH => 'Applet-URL invalid. Use one of the form geogebra.org/m/id or ggbm.at/id'
                            ]
                        ]
                    ]
                ]
            ]);
        $inputFilter->add(['name' => 'content', 'required' => false, 'filters' => [['name' => 'HtmlEntities']]]);
        $inputFilter->add(['name' => 'meta_title', 'required' => false, 'filters' => [['name' => 'HtmlEntities']]]);
        $inputFilter->add(['name' => 'meta_description', 'required' => false, 'filters' => [['name' => 'HtmlEntities']]]);
        $inputFilter->add(['name' => 'reasoning', 'required' => false, 'filters' => [['name' => 'HtmlEntities']]]);
        $inputFilter->add(['name' => 'changes', 'required' => false, 'filters' => [['name' => 'HtmlEntities' ]]]);
        $this->setInputFilter($inputFilter);
    }
}
