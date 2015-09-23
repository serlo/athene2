<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Jonas Keinholz (jonas.keinholz@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\View\Helper;

use Instance\Manager\InstanceManagerInterface;
use Zend\View\Helper\AbstractHelper;

class LanguageHelper extends AbstractHelper
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
        $currentInstance = $this->instanceManager->getInstanceFromRequest();
        return $currentInstance->getLanguage()->getCode();
    }
}
