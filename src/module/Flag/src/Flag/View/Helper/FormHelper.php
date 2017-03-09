<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Flag\View\Helper;

use Flag\Form\RemoveFlagForm;
use Zend\Form\Form;
use Zend\View\Helper\AbstractHelper;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getForm($flagId)
    {
        $url = $this->getView()->url('flag/remove', ['id' => $flagId]);
        /** @var Form $form */
        $form = new RemoveFlagForm();
        $form->setAttribute('action', $url);
        return $form;
    }
}
