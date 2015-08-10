<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\View\Helper;

use Alias\AliasManagerAwareTrait;
use Alias\AliasManagerInterface;
use Alias\Exception\AliasNotFoundException;
use Common\Traits\ConfigAwareTrait;
use Instance\Manager\InstanceManagerAwareTrait;
use Instance\Manager\InstanceManagerInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Mvc\Router\Console\RouteInterface;
use Zend\View\Helper\Url as ZendUrl;

class Url extends ZendUrl
{
    use AliasManagerAwareTrait, InstanceManagerAwareTrait;

    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(
        AliasManagerInterface $aliasManager,
        InstanceManagerInterface $instanceManager
    ) {
        $this->aliasManager    = $aliasManager;
        $this->instanceManager = $instanceManager;
    }

    public function __invoke($name = null, $params = [], $options = [], $reuseMatchedParams = false, $useAlias = true)
    {
        $useCanonical = (isset($options['force_canonical']) && $options['force_canonical']);
        $link         = parent::__invoke($name, $params, $options, $reuseMatchedParams);

        if (!$useAlias) {
            return $link;
        }

        try {
            $aliasManager = $this->getAliasManager();
            $instance     = $this->getInstanceManager()->getInstanceFromRequest();
            if ($useCanonical) {
                $options['force_canonical'] = false;
                $source                     = parent::__invoke($name, $params, $options, $reuseMatchedParams);
                $link                       = $aliasManager->findAliasBySource($source, $instance);
                return $this->getView()->serverUrl($link);
            }
            $link = $aliasManager->findAliasBySource($link, $instance);
        } catch (AliasNotFoundException $e) {
            // No alias was found -> nothing to do
        }

        return $link;
    }
}
