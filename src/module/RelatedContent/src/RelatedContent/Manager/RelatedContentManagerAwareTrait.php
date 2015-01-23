<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Manager;

trait RelatedContentManagerAwareTrait
{

    /**
     * @var RelatedContentManagerInterface
     */
    protected $relatedContentManager;

    /**
     * @return RelatedContentManagerInterface $relatedContentManager
     */
    public function getRelatedContentManager()
    {
        return $this->relatedContentManager;
    }

    /**
     * @param RelatedContentManagerInterface $relatedContentManager
     * @return self
     */
    public function setRelatedContentManager(RelatedContentManagerInterface $relatedContentManager)
    {
        $this->relatedContentManager = $relatedContentManager;
        return $this;
    }
}
