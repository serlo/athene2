<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Uuid\View\Helper;

use Uuid\Form\PurgeForm;
use Uuid\Form\TrashForm;
use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getForm($action, $objectID)
    {
        if ($action === 'trash') {
            $url = $this->getView()->url('uuid/trash', ['id' => $objectID]);
            /** @var Form $form */
            $form = new TrashForm($objectID);
            $form->setAttribute('action', $url);
            return $form;
        } else if ($action === 'purge') {
            $url = $this->getView()->url('uuid/purge', ['id' => $objectID]);
            /** @var Form $form */
            $form = new PurgeForm($objectID);
            $form->setAttribute('action', $url);
            return $form;
        }
    }
}
