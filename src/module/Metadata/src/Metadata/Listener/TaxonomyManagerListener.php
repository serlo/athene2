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
namespace Metadata\Listener;

use Metadata\Exception\DuplicateMetadata;
use Metadata\Exception\MetadataNotFoundException;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Uuid\Entity\UuidInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class TaxonomyManagerListener extends AbstractListener
{

    public function onCreate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term = $e->getParam('term');

        if ($term->hasParent()) {
            $parent = $term->getParent();
            $this->addMetadata($parent, $term);
        }
    }

    protected function addMetadata(UuidInterface $object, TaxonomyTermInterface $term)
    {
        while ($term->hasParent()) {
            try {
                $this->getMetadataManager()->addMetadata(
                    $object,
                    $term->getTaxonomy()->getName(),
                    $term->getName()
                );
            } catch (DuplicateMetadata $e) {
            }
            $term = $term->getParent();
        }
    }

    public function onUpdate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term = $e->getParam('term');

        if ($term->hasParent()) {
            $parent = $term->getParent();
            $this->addMetadata($parent, $term);
        }
    }

    public function onAssociate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term   = $e->getParam('term');
        $object = $e->getParam('object');

        if ($object instanceof TaxonomyTermAwareInterface && $object instanceof UuidInterface) {
            $this->addMetadata($object, $term);
        }
    }

    public function onDissociate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term   = $e->getParam('term');
        $object = $e->getParam('object');

        if ($object instanceof TaxonomyTermAwareInterface && $object instanceof UuidInterface) {
            $this->removeMetadata($object, $term);
        }
    }

    protected function removeMetadata($object, TaxonomyTermInterface $term)
    {
        while ($term->hasParent()) {
            try {
                $metadata = $this->getMetadataManager()->findMetadataByObjectAndKeyAndValue(
                    $object,
                    $term->getTaxonomy()->getName(),
                    $term->getName()
                );
                $this->getMetadataManager()->removeMetadata($metadata->getId());
            } catch (MetadataNotFoundException $e) {
            }
            $term = $term->getParent();
        }
    }

    public function attachShared(SharedEventManagerInterface $events)
    {
        $monitoredClass = $this->getMonitoredClass();
        $events->attach($monitoredClass, 'create', [$this, 'onCreate']);
        $events->attach($monitoredClass, 'update', [$this, 'onUpdate']);
        $events->attach($monitoredClass, 'associate', [$this, 'onAssociate']);
        $events->attach($monitoredClass, 'dissociate', [$this, 'onDissociate']);
    }

    protected function getMonitoredClass()
    {
        return 'Taxonomy\Manager\TaxonomyManager';
    }
}
