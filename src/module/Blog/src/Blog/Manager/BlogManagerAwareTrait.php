<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Blog\Manager;

trait BlogManagerAwareTrait
{

    /**
     * @var BlogManagerInterface
     */
    protected $blogManager;

    /**
     * @return BlogManagerInterface $blogManager
     */
    public function getBlogManager()
    {
        return $this->blogManager;
    }

    /**
     * @param BlogManagerInterface $blogManager
     * @return self
     */
    public function setBlogManager(BlogManagerInterface $blogManager)
    {
        $this->blogManager = $blogManager;

        return $this;
    }
}
