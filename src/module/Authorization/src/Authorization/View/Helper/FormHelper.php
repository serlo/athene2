<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\View\Helper;

use Authorization\Form\RemovePermissionForm;
use Authorization\Form\RemoveUserForm;
use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;

class FormHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    public function getRemoveUserForm($username, $roleID)
    {
        $url = $this->getView()->url('authorization/role/user/remove', ['role' => $roleID]);
        /** @var Form $form */
        $form = new RemoveUserForm($username);
        $form->setAttribute('action', $url);
        return $form;
    }

    public function getRemovePermissionForm($roleID, $permissionID) {
        $url = $this->getView()->url('authorization/role/permission/remove',
        ['role' => $roleID, 'permission' => $permissionID]);

            /** @var Form $form */
        $form = new RemovePermissionForm($roleID, $permissionID);
        $form->setAttribute('action', $url);
        return $form;
    }
}
