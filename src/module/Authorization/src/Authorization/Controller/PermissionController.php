<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license      LGPL-3.0
 * @license      http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Authorization\Controller;

use Authorization\Service\PermissionServiceAwareTrait;
use Authorization\Service\PermissionServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class PermissionController extends AbstractActionController
{
    use PermissionServiceAwareTrait;

    /**
     * @param PermissionServiceInterface $permissionService
     */
    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return ViewModel
     */
    public function permissionsAction()
    {
        $permissions = $this->getPermissionService()->findAllPermissions();
        $view        = new ViewModel(['permissions' => $permissions]);
        $view->setTemplate('authorization/permission/permissions');
        return $view;
    }
}
