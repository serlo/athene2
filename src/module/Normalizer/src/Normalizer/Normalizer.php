<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer;

use Normalizer\Adapter\AdapterPluginManager;
use Zend\Cache\Storage\StorageInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Normalizer implements NormalizerInterface
{

    /**
     * @var Adapter\AdapterPluginManager
     */
    protected $pluginManager;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var array
     */
    protected $adapters = [
        'Attachment\Entity\ContainerInterface'  => 'Normalizer\Adapter\AttachmentAdapter',
        'Discussion\Entity\CommentInterface'    => 'Normalizer\Adapter\CommentAdapter',
        'Entity\Entity\EntityInterface'         => 'Normalizer\Adapter\EntityAdapter',
        'Entity\Entity\RevisionInterface'       => 'Normalizer\Adapter\EntityRevisionAdapter',
        'Page\Entity\PageRepositoryInterface'   => 'Normalizer\Adapter\PageRepositoryAdapter',
        'Page\Entity\PageRevisionInterface'     => 'Normalizer\Adapter\PageRevisionAdapter',
        'Blog\Entity\PostInterface'             => 'Normalizer\Adapter\PostAdapter',
        'Taxonomy\Entity\TaxonomyTermInterface' => 'Normalizer\Adapter\TaxonomyTermAdapter',
        'User\Entity\UserInterface'             => 'Normalizer\Adapter\UserAdapter',
    ];

    public function __construct(StorageInterface $storage, AdapterPluginManager $pluginManager = null)
    {
        if (!$pluginManager) {
            $pluginManager = new AdapterPluginManager();
        }
        $this->pluginManager = $pluginManager;
        $this->storage       = $storage;
    }

    public function normalize($object)
    {
        if (!is_object($object)) {
            throw new Exception\InvalidArgumentException(sprintf('Expected object but got %s.', gettype($object)));
        }

        $key = hash('sha256', serialize($object));

        if ($this->storage->hasItem($key)) {
            return unserialize($this->storage->getItem($key));
        }

        foreach ($this->adapters as $class => $adapterClass) {
            if ($object instanceof $class) {
                /* @var $adapterClass Adapter\AdapterInterface */
                $adapter    = $this->pluginManager->get($adapterClass);
                $normalized = $adapter->normalize($object);
                $this->storage->setItem($key, serialize($normalized));
                return $normalized;
            }
        }

        throw new Exception\NoSuitableAdapterFoundException($object);
    }
}
