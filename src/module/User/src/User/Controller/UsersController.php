<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Controller;

use Zend\View\Model\ViewModel;

class UsersController extends AbstractUserController
{
    public function usersAction()
    {
        $page  = $this->params()->fromQuery('page', 0);
        $users = $this->getUserManager()->findAllUsers($page);
        $view  = new ViewModel(['users' => $users]);
        return $view;
    }
}
