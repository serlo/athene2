<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\Listener;

use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class BlogManagerListener extends AbstractListener
{
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            'create',
            [
                $this,
                'onUpdate',
            ]
        );

        $events->attach(
            $this->getMonitoredClass(),
            'update',
            [
                $this,
                'onUpdate',
            ]
        );
    }

    protected function getMonitoredClass()
    {
        return 'Blog\Manager\BlogManager';
    }

    /**
     * Gets executed on post create & update
     *
     * @param Event $e
     * @return void
     */
    public function onUpdate(Event $e)
    {
        /* @var $post \Blog\Entity\PostInterface */
        $post     = $e->getParam('post');
        $instance = $post->getInstance();

        if ($post->getId() === null) {
            $this->getAliasManager()->flush($post);
        }

        $url = $this->getAliasManager()->getRouter()->assemble(
            ['post' => $post->getId()],
            ['name' => 'blog/post/view']
        );

        $this->getAliasManager()->autoAlias('blogPost', $url, $post, $instance);
    }
}
