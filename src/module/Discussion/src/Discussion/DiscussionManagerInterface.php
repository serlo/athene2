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

use Common\ObjectManager\Flushable;
use Discussion\Entity\CommentInterface;
use Instance\Entity\InstanceInterface;
use Uuid\Entity\UuidInterface;
use Zend\Form\FormInterface;
use Doctrine\Common\Collections\Collection;

interface DiscussionManagerInterface extends Flushable
{
    /**
     * @param FormInterface $form
     * @return CommentInterface
     */
    public function commentDiscussion(FormInterface $form);

    /**
     * @param InstanceInterface $instance
     * @param int               $page
     * @param int               $limit
     * @return CommentInterface[]|Collection
     */
    public function findDiscussionsByInstance(InstanceInterface $instance, $page, $limit = 20);

    /**
     * Finds discussions on a uuid
     *
     * @param UuidInterface $uuid
     * @return CommentInterface[]|Collection
     */
    public function findDiscussionsOn(UuidInterface $uuid);

    /**
     * @param Collection $collection
     * @return Collection
     */
    public function sortDiscussions(Collection $collection);

    /**
     * Returns a comment
     *
     * @param int $id
     * @return CommentInterface
     */
    public function getComment($id);

    /**
     * @param FormInterface $form
     * @return CommentInterface
     */
    public function startDiscussion(FormInterface $form);

    /**
     * @param int $commentId
     * @return void
     */
    public function toggleArchived($commentId);
}
