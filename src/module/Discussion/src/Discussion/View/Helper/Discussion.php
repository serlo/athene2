<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Discussion\View\Helper;

use Discussion\Entity\CommentInterface;
use Discussion\Exception\RuntimeException;
use Discussion\Form\CommentForm;
use Discussion\Form\DiscussionForm;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\Entity;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Form\TermForm;
use Uuid\Entity\UuidInterface;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
use ZfcTwig\View\TwigRenderer;

class Discussion extends AbstractHelper
{
    use \Discussion\DiscussionManagerAwareTrait, \Common\Traits\ConfigAwareTrait, \User\Manager\UserManagerAwareTrait,
        \Taxonomy\Manager\TaxonomyManagerAwareTrait, \Instance\Manager\InstanceManagerAwareTrait;

    protected $discussions, $object;

    protected $form;

    protected $archived;

    protected $forum;

    /**
     * @var TermForm
     */
    protected $termForm;

    /**
     * @var \Discussion\Form\CommentForm
     */
    protected $commentForm;

    /**
     * @var \Discussion\Form\DiscussionForm
     */
    protected $discussionForm;

    /**
     * @var \ZfcTwig\View\TwigRenderer
     */
    protected $renderer;

    /**
     * @var array
     */
    protected $inMemory = [];

    public function __construct(
        TermForm $termForm,
        CommentForm $commentForm,
        DiscussionForm $discussionForm,
        TwigRenderer $renderer
    ) {
        $this->renderer       = $renderer;
        $this->form           = [];
        $this->termForm       = $termForm;
        $this->commentForm    = $commentForm;
        $this->discussionForm = $discussionForm;
    }

    public function __invoke(UuidInterface $object = null, $forum = null, $archived = null)
    {
        if ($object !== null) {
            $this->discussions = $this->getDiscussionManager()->findDiscussionsOn($object, $archived);
            $this->setObject($object);
        }
        if ($archived !== null) {
            $this->setArchived($archived);
        }
        if ($forum !== null) {
            $this->setForum($forum);
        }
        return $this;
    }

    /**
     * @return boolean $archived
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     * @return self
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }

    public function getDiscussions(UuidInterface $object)
    {
        $discussions = $this->getDiscussionManager()->findDiscussionsOn($object);
        $discussions = $discussions->filter(
            function (CommentInterface $comment) {
                return !$comment->isTrashed();
            }
        );
        return $discussions;
    }

    public function getForm($type, UuidInterface $object, TaxonomyTermInterface $forum = null)
    {
        $view = $this->getView();
        $queries = ['query' => ['redirect' => $view->serverUrl(true)]];

        switch ($type) {
            case 'discussion':
                $form = clone $this->discussionForm;
                $form->setAttribute(
                    'action',
                    $view->url(
                        'discussion/discussion/start',
                        ['on' => $object->getId()],
                        $queries
                    )
                );
                return $form;
                break;
            case 'comment':
                $form = clone $this->commentForm;
                $form->setAttribute(
                    'action',
                    $view->url(
                        'discussion/discussion/comment',
                        ['discussion' => $object->getId()],
                        $queries
                    )
                );
                return $form;
                break;
            default:
                throw new RuntimeException();
        }
    }

    public function getForum()
    {
        return $this->forum;
    }

    public function setForum(TaxonomyTermInterface $forum)
    {
        $this->forum = $forum;
        return $this;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getUser()
    {
        return $this->getUserManager()->getUserFromAuthenticator();
    }

    public function render($template = null, $leftWidth = 2)
    {
        $template = $template ? 'discussion/helper/' . $template . '/' . $template : $this->getOption('template');
        return $this->renderer->render(
            $template,
            [
                'discussions' => $this->discussions,
                'isArchived'  => $this->archived,
                'object'      => $this->getObject(),
                'forum'     => $this->getForum(),
                'leftWidth' => $leftWidth
            ]
        );
    }

    public function setObject(UuidInterface $object)
    {
        $this->object = $object;
        return $this;
    }

    public function sortDiscussions(Collection $collection)
    {
        return $this->discussionManager->sortDiscussions($collection);
    }

    protected function getDefaultConfig()
    {
        return [
            'template' => 'discussion/helper/default/default',
            'root'     => 'root',
            'forum'    => 'forum'
        ];
    }
}
