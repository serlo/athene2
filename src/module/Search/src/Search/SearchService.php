<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search;

use Search\Adapter\AdapterInterface;
use Search\Options\ModuleOptions;
use Search\Provider\ProviderPluginManager;
use Search\Exception\InvalidArgumentException;

class SearchService implements SearchServiceInterface
{
    /**
     * @var Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var Provider\ProviderPluginManager
     */
    protected $providerPluginManager;

    /**
     * @var Options\ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @param AdapterInterface      $adapter
     * @param ModuleOptions         $moduleOptions
     * @param ProviderPluginManager $providerPluginManager
     */
    public function __construct(
        AdapterInterface $adapter,
        ModuleOptions $moduleOptions,
        ProviderPluginManager $providerPluginManager
    ) {
        $this->adapter               = $adapter;
        $this->moduleOptions         = $moduleOptions;
        $this->providerPluginManager = $providerPluginManager;
    }

    /**
     * {@inheritDoc}
     */
    public function add($object)
    {
        $providers = $this->moduleOptions->getProviders();
        foreach ($providers as $provider) {
            /* @var $provider Provider\ProviderInterface */
            $provider = $this->providerPluginManager->get($provider);
            try {
                $document = $provider->toDocument($object);
                $this->adapter->add($document);
            } catch (InvalidArgumentException $e) {
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete($object)
    {
        $providers = $this->moduleOptions->getProviders();
        foreach ($providers as $provider) {
            /* @var $provider Provider\ProviderInterface */
            $provider = $this->providerPluginManager->get($provider);
            try {
                $id = $provider->getId($object);
                $this->adapter->delete($id);
            } catch (InvalidArgumentException $e) {
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function erase()
    {
        $this->adapter->erase();
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        $this->adapter->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function rebuild()
    {
        ini_set('mysql.connect_timeout', 60 * 30);
        ini_set('default_socket_timeout', 60 * 30);

        $this->erase();
        $providers = $this->moduleOptions->getProviders();
        foreach ($providers as $provider) {
            /* @var $provider Provider\ProviderInterface */
            $provider = $this->providerPluginManager->get($provider);
            $results  = $provider->provide();
            foreach ($results as $result) {
                $this->adapter->add($result);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function search($query, $page = 0, $itemsPerPage = 20)
    {
        $paginator = $this->adapter->search($query);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($itemsPerPage);
        return $paginator;
    }
}
