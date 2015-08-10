<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\Entity;

use Instance\Entity\InstanceAwareInterface;
use Page\Entity\PageRepositoryInterface;

interface AdPageInterface extends InstanceAwareInterface
{
    /**
     * Gets the Repository
     *
     * @return PageRepositoryInterface 
     */
    public function getPageRepository();
}
