<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\View\Helper;

use Ads\Form\RemoveAdForm;
use Zend\Form\Form;
use Zend\View\Helper\AbstractHelper;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getForm($objectID)
    {
        $url = $this->getView()->url('ads/ad/delete', ['id' => $objectID]);
        /** @var Form $form */
        $form = new RemoveAdForm();
        $form->setAttribute('action', $url);
        return $form;
    }
}
