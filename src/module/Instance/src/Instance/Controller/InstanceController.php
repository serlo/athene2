<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Controller;

use Instance\Exception\InstanceNotFoundException;
use Instance\Manager\InstanceManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;

class InstanceController extends AbstractActionController
{
    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    public function __construct(InstanceManagerInterface $instanceManager)
    {
        $this->instanceManager = $instanceManager;
    }

    public function switchAction()
    {
        $instance = $this->params('instance');
        try {
            $this->instanceManager->switchInstance($instance);
        } catch (InstanceNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        return $this->redirect()->toRoute('home');
    }
}
