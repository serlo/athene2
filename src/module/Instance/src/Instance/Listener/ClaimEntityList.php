<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Listener;

use Doctrine\Common\EventArgs;
use Doctrine\Common\EventSubscriber;
use Instance\Entity\InstanceInterface;

class ClaimEntityListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return ['prePersist'];
    }

    /**
     * @param EventArgs $args
     */
    public function prePersist(EventArgs $args)
    {
        $em     = $args->getEntityManager();
        $entity = $args->getEntity();

        if ($entity instanceof InstanceInterface && !$entity->getInstance() && $tenant = $em->getTenant()) {
            $entity->setTenant($tenant);
        }
    }
}
