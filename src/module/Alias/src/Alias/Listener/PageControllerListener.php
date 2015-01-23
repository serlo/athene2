<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\Listener;

use Page\Entity\PageRepositoryInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class PageControllerListener extends AbstractListener
{

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'page.create.postFlush', [$this, 'onUpdate']);
    }

    /**
     * Gets executed on page create
     *
     * @param Event $e
     * @return void
     */
    public function onUpdate(Event $e)
    {
        /* @var $repository PageRepositoryInterface */
        $slug       = $e->getParam('slug');
        $repository = $e->getParam('repository');
        $url        = $e->getTarget()->url()->fromRoute('page/view', ['page' => $repository->getId()], null, null, false);
        $alias      = $this->getAliasManager()->createAlias(
            $url,
            $slug,
            $slug . '-' . $repository->getId(),
            $repository,
            $repository->getInstance()
        );
        $this->getAliasManager()->flush($alias);
    }

    protected function getMonitoredClass()
    {
        return 'Page\Controller\IndexController';
    }
}
