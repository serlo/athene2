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
namespace Alias\View\Helper;

use Alias\AliasManagerInterface;
use Exception;
use Instance\Manager\InstanceManagerInterface;
use Zend\View\Helper\AbstractHelper;

class AliasHelper extends AbstractHelper
{
    /**
     * @var AliasManagerInterface
     */
    protected $aliasManager;

    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    public function __construct(AliasManagerInterface $aliasManager, InstanceManagerInterface $instanceManager)
    {
        $this->aliasManager    = $aliasManager;
        $this->instanceManager = $instanceManager;
    }

    public function __invoke($source)
    {
        try {
            $instance = $this->instanceManager->getInstanceFromRequest();
            return $this->aliasManager->findAliasBySource($source, $instance);
        } catch (Exception $e) {
            return $source;
        }
    }
}
