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
namespace Alias\Controller\Plugin;

use Alias\AliasManagerInterface;
use Alias\Exception\AliasNotFoundException;
use Instance\Manager\InstanceManagerInterface;
use Zend\Mvc\Controller\Plugin\Url as ZendUrl;
use Zend\Mvc\Exception;

class Url extends ZendUrl
{
    /**
     * @param AliasManagerInterface    $aliasManager
     * @param InstanceManagerInterface $instanceManager
     */
    public function __construct(
        AliasManagerInterface $aliasManager,
        InstanceManagerInterface $instanceManager
    ) {
        $this->aliasManager    = $aliasManager;
        $this->instanceManager = $instanceManager;
    }

    public function fromRoute(
        $route = null,
        $params = array(),
        $options = array(),
        $reuseMatchedParams = false,
        $useAlias = true
    ) {
        $url = parent::fromRoute($route, $params, $options, $reuseMatchedParams);

        if (!$useAlias) {
            return $url;
        }

        $aliasManager = $this->aliasManager;
        $instance = $this->instanceManager->getInstanceFromRequest();

        try {
            $url = $aliasManager->findAliasBySource($url, $instance);
        } catch (AliasNotFoundException $e) {
            // Nothing to do..
        }

        return $url;
    }
}
