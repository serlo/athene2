<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Application\Controller;

use Instance\Manager\InstanceManagerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    use InstanceManagerAwareTrait;

    public function indexAction()
    {
        $view = new ViewModel();
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        $this->layout('layout/' . $instance->getSubdomain() . '/home');

        return $view;
    }
}
