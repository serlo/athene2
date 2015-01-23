<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Event\Listener;

use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\EventManager\Event;

class TaxonomyManagerListener extends AbstractListener
{

    public function attachShared(\Zend\EventManager\SharedEventManagerInterface $events)
    {
        $class = $this->getMonitoredClass();
        $events->attach($class, 'parent.change', [$this, 'onParentChange']);
        $events->attach($class, 'create', [$this, 'onCreate']);
        $events->attach($class, 'update', [$this, 'onUpdate']);
        $events->attach($class, 'associate', [$this, 'onAssociate']);
        $events->attach($class, 'dissociate', [$this, 'onDissociate']);
    }

    protected function getMonitoredClass()
    {
        return 'Taxonomy\Manager\TaxonomyManager';
    }

    public function onAssociate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term     = $e->getParam('term');
        $instance = $term->getInstance();

        $this->logEvent(
            'taxonomy/term/associate',
            $instance,
            $term,
            [
                [
                    'name'  => 'object',
                    'value' => $e->getParam('object')
                ]
            ]
        );
    }

    public function onCreate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term     = $e->getParam('term');
        $instance = $term->getInstance();

        $this->logEvent('taxonomy/term/create', $instance, $term);
    }

    public function onDissociate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term     = $e->getParam('term');
        $instance = $term->getInstance();

        $this->logEvent(
            'taxonomy/term/dissociate',
            $instance,
            $term,
            [
                [
                    'name'  => 'object',
                    'value' => $e->getParam('object')
                ]
            ]
        );
    }

    public function onParentChange(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term     = $e->getParam('term');
        $from     = $e->getParam('from');
        $to       = $e->getParam('to');
        $instance = $term->getInstance();

        $this->logEvent(
            'taxonomy/term/parent/change',
            $instance,
            $term,
            [
                [
                    'name'  => 'from',
                    'value' => $from ? $from : 'no parent'
                ],
                [
                    'name'  => 'to',
                    'value' => $to ? $from : 'no parent'
                ]
            ]
        );
    }

    public function onUpdate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term     = $e->getParam('term');
        $instance = $term->getInstance();

        $this->logEvent('taxonomy/term/update', $instance, $term);
    }
}
