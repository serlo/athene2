<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Form;

use Common\Filter\PreviewFilter;
use Taxonomy\Hydrator\TaxonomyTermHydrator;
use Term\Form\TermFieldset;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class BatchCopyForm extends Form
{

    function __construct(array $associations = [])
    {
        parent::__construct('taxonomyTerm');
        $this->setAttribute('method', 'post');
        $filter = new InputFilter();
        $this->setInputFilter($filter);

        $this->add(
            (new Text('destination'))
                ->setAttribute('id', 'destination')
                ->setAttribute('placeholder', 'ID (12345)')
                ->setLabel('Copy to:')
        );

        $multiCheckbox = new MultiCheckbox('associations');
        $multiCheckbox->setLabel('Elements')->setAttribute('id', 'associations');
        $multiCheckbox->setValueOptions($associations);
        $this->add($multiCheckbox);

        $this->add((new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right'));

        $filter->add(
            [
                'name'        => 'destination',
                'required'    => true,
                'allow_empty' => false,
                'filters'     => [
                    ['name' => 'Int']
                ],
                'validators'  => [
                    ['name' => 'Digits']
                ]
            ]
        );
    }
}
