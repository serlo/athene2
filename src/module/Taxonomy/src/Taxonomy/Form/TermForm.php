<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Form;

use Common\Form\Element\CsrfToken;
use Taxonomy\Hydrator\TaxonomyTermHydrator;
use Term\Form\TermFieldset;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class TermForm extends Form
{
    public function __construct(TaxonomyTermHydrator $taxonomyTermHydrator)
    {
        parent::__construct('taxonomyTerm');
        $this->add(new CsrfToken('csrf'));

        $this->setAttribute('method', 'post');
        $filter = new InputFilter();
        $this->setInputFilter($filter);
        $this->setHydrator($taxonomyTermHydrator);

        $this->add(
            [
                'name'       => 'parent',
                'attributes' => [
                    'type' => 'hidden',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'position',
                'attributes' => [
                    'type' => 'hidden',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'taxonomy',
                'attributes' => [
                    'type' => 'hidden',
                ],
            ]
        );

        $this->add(new TermFieldset());

        $this->add((new Textarea('description'))->setAttribute('id', 'description')->setLabel('description:'));

        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right')
        );

        $filter->add(
            [
                'name'     => 'description',
                'required' => false,
                'filters'  => [
                    [
                        'name' => 'StripTags',
                    ],
                ],
            ]
        );
        $filter->add(
            [
                'name'     => 'taxonomy',
                'required' => true,
            ]
        );
    }
}
