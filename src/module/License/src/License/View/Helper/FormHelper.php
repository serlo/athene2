<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace License\View\Helper;

use License\Form\RemoveLicenseForm;
use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getForm($licenseID)
    {
        $url = $this->getView()->url('license/remove', ['id' => $licenseID]);
        /** @var Form $form */
        $form = new RemoveLicenseForm();
        $form->setAttribute('action', $url);
        return $form;
    }
}
