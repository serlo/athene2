<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Discussion\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Instance\Entity\InstanceAwareInterface;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

interface CommentInterface extends TaxonomyTermAwareInterface, InstanceAwareInterface, UuidInterface
{

    /**
     * @param CommentInterface $comment
     * @return self
     */
    public function addChild(CommentInterface $comment);

    /**
     * @return int
     */
    public function countDownVotes();

    /**
     * @return int
     */
    public function countUpVotes();

    /**
     * @param UserInterface $user
     * @return self
     */
    public function downVote(UserInterface $user);

    /**
     * @return bool
     */
    public function getArchived();

    /**
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * @return Collection
     */
    public function getChildren();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return UuidInterface
     */
    public function getObject();

    /**
     * @return CommentInterface
     */
    public function getParent();

    /**
     * @return DateTime
     */
    public function getTimestamp();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return boolean
     */
    public function hasParent();

    /**
     * @param UserInterface $user
     * @return self
     */
    public function hasUserVoted(UserInterface $user);

    /**
     * @param bool $archived
     * @return self
     */
    public function setArchived($archived);

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setAuthor(UserInterface $user);

    /**
     * @param string $content
     * @return self
     */
    public function setContent($content);

    /**
     * @param UuidInterface $uuid
     * @return self
     */
    public function setObject(UuidInterface $uuid);

    /**
     * @param CommentInterface $comment
     * @return self
     */
    public function setParent(CommentInterface $comment);

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title);

    /**
     * @param UserInterface $user
     * @return self
     */
    public function upVote(UserInterface $user);
}
