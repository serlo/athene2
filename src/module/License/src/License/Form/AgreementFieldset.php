<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace License\Form;

use License\Entity\LicenseInterface;
use Zend\Form\Element\Checkbox;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AgreementFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(LicenseInterface $license)
    {
        parent::__construct('license');
        $agreement = $license->getAgreement() ? : $license->getTitle();
        $checkbox  = new Checkbox('agreement');
        $checkbox->setOptions(
            [
                'use_hidden_element' => false,
            ]
        );
        $checkbox->setLabel($agreement);
        $checkbox->setLabelOptions(['disable_html_escape' => true]);
        $this->add($checkbox);
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            [
                'name'     => 'agreement',
                'required' => true,
            ]
        ];
    }
}
