<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
