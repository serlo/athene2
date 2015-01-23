<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
