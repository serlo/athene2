<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\View\Helper;

use RelatedContent\Form\RemoveRelatedElementForm;
use Zend\Form\Form;
use Zend\View\Helper\AbstractHelper;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getForm($elementId)
    {
        $url = $this->getView()->url('related-content/remove', ['id' => $elementId]);
        /** @var Form $form */
        $form = new RemoveRelatedElementForm();
        $form->setAttribute('action', $url);
        return $form;
    }
}