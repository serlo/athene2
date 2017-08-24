<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\View\Helper;

use Common\Form\CsrfForm;
use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getTrashForm($objectID)
    {
        $url = $this->getView()->url('uuid/trash', ['id' => $objectID]);
        /** @var Form $form */
        $form = new CsrfForm('uuid-trash');
        $form->setAttribute('action', $url);
        return $form;
    }
    public function getPurgeForm($objectID) {
        $url = $this->getView()->url('uuid/purge', ['id' => $objectID]);
        /** @var Form $form */
        $form = new CsrfForm('uuid-purge');
        $form->setAttribute('action', $url);
        return $form;
    }
}
