<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Discussion;

trait DiscussionManagerAwareTrait
{

    /**
     * @var DiscussionManagerInterface
     */
    protected $discussionManager;

    /**
     * @return DiscussionManagerInterface $discussionManager
     */
    public function getDiscussionManager()
    {
        return $this->discussionManager;
    }

    /**
     * @param DiscussionManagerInterface $discussionManager
     * @return self
     */
    public function setDiscussionManager(DiscussionManagerInterface $discussionManager)
    {
        $this->discussionManager = $discussionManager;

        return $this;
    }
}
