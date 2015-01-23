<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity\Form;

use Notification\Form\OptInFieldset;
use Zend\Form\Element\Submit;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class Controls extends Fieldset implements InputFilterProviderInterface
{

    public function __construct()
    {
        parent::__construct('controls');

        $this->add(new OptInFieldset());

        $this->add(
            (new Submit('submit'))->setValue('Save')->setAttribute('class', 'btn btn-success pull-right')
        );
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}
