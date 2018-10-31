<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Page\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class RoleFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('components');
        $this->setHydrator(new DoctrineObject($objectManager));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'field' => array(
                'required'   => false,
                'filters'    => array(),
                'validators' => array(),
            ),
        );
    }
}
