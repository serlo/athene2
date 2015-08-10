<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
