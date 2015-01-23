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

use Doctrine\ORM\Mapping as ORM;
use User\Entity\UserInterface;

/**
 * Comment vote ORM Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="comment_vote")
 */
class Vote implements VoteInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id = "asdf";

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="votes")
     */
    protected $comment;

    /**
     * @ORM\Column(type="integer")
     */
    protected $vote;

    public function getVote()
    {
        return $this->vote;
    }

    public function setVote($vote)
    {
        $this->vote = $vote;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    public function setComment(CommentInterface $comment)
    {
        $this->comment = $comment;
    }
}
