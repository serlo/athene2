<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Navigation\View\Helper;

use Exception;
use Zend\Cache\Storage\StorageInterface;

class Menu extends \Zend\View\Helper\Navigation\Menu
{
    /**
     * @var \Zend\Cache\Storage\StorageInterface
     */
    protected $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function render($container = null)
    {
        $container = $container ? $container : $this->getContainer();

        try {
            $output = parent::render($container);
            return $output;
        } catch (Exception $e) {
            return '<div class="alert-danger alert"><span class="fa fa-exclamation-triangle"></span> ' . $e->getMessage(
            ) . '</div>';
        }
    }
}
