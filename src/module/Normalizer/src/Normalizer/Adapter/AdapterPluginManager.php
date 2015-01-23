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
namespace Normalizer\Adapter;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class AdapterPluginManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $invokableClasses = [
        'Normalizer\Adapter\AttachmentAdapter',
        'Normalizer\Adapter\CommentAdapter',
        'Normalizer\Adapter\EntityAdapter',
        'Normalizer\Adapter\EntityRevisionAdapter',
        'Normalizer\Adapter\PageRepositoryAdapter',
        'Normalizer\Adapter\PageRevisionAdapter',
        'Normalizer\Adapter\PostAdapter',
        'Normalizer\Adapter\TaxonomyTermAdapter',
        'Normalizer\Adapter\UserAdapter',
    ];

    /**
     * Validate the plugin
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof AdapterInterface) {
            throw new Exception\RuntimeException(sprintf(
                'Expected AdapterInterface but got %s',
                is_object($plugin) ? get_class($plugin) : gettype($plugin)
            ));
        }
    }
}
