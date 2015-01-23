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

use User\Entity\UserInterface;

interface VoteInterface
{

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param CommentInterface $comment
     * @return self
     */
    public function setComment(CommentInterface $comment);

    /**
     * @return CommentInterface
     */
    public function getComment();

    /**
     * @param int $type
     * @return self
     */
    public function setVote($type);

    /**
     * @return int
     */
    public function getVote();
}
