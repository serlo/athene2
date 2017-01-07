<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace License\Form;

use License\Hydrator\LicenseHydrator;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Url;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class LicenseForm extends Form
{
    public function __construct()
    {
        parent::__construct('license');
        $this->add(new Csrf('license_csrf'));

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');
        $this->setHydrator(new LicenseHydrator());
        $inputFilter = new InputFilter('license');
        $this->setInputFilter($inputFilter);

        $this->add((new Text('title'))->setLabel('Title:')->setAttribute('id', 'title'));
        $this->add((new Textarea('content'))->setLabel('Content:')->setAttribute('id', 'content'));
        $this->add((new Url('url'))->setLabel('License url:')->setAttribute('id', 'url'));
        $this->add((new Textarea('agreement'))->setLabel('Agreement:')->setAttribute('id', 'agreement')->setAttribute(
            'class',
            'plain'
        ));
        $this->add((new Url('iconHref'))->setLabel('Icon url:')->setAttribute('id', 'iconHref'));
        $this->add((new Checkbox('default'))->setLabel('This is the default license for this instance.')->setAttribute('id', 'default'));

        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right')
        );

        $inputFilter->add(
            [
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'content',
                'required' => false,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'iconHref',
                'required' => false,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ]
                ]
            ]
        );

        $inputFilter->add(
            [
                'name'     => 'url',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ]
                ]
            ]
        );
    }
}
