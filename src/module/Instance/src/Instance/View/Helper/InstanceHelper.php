<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\View\Helper;

use Instance\Manager\InstanceManagerInterface;
use Zend\View\Helper\AbstractHelper;

class InstanceHelper extends AbstractHelper
{
    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    /**
     * @param InstanceManagerInterface $instanceManager
     */
    public function __construct(InstanceManagerInterface $instanceManager)
    {
        $this->instanceManager = $instanceManager;
    }

    public function __invoke()
    {
        return $this;
    }

    public function renderSelect()
    {
        $data = [
            'instances' => $this->instanceManager->findAllInstances(),
            'current'   => $this->instanceManager->getInstanceFromRequest()
        ];

        return $this->getView()->partial('instance/helper/select', $data);
    }
}
