<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Navigation\Form;

use Common\Form\Element\CsrfToken;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as ObjectHydrator;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ParameterKeyForm extends Form
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('parameterKey');
        $this->add(new CsrfToken('csrf'));

        $hydrator = new ObjectHydrator($entityManager);
        $filter   = new InputFilter();

        $this->setHydrator($hydrator);
        $this->setInputFilter($filter);

        $this->add((new Text('name')));

        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right')
        );

        $filter->add(
            [
                'name'     => 'name',
                'required' => true,
            ]
        );
    }
}
