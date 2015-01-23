<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Strategy;

use Instance\Entity\InstanceInterface;
use Instance\Manager\InstanceManagerInterface;

interface StrategyInterface
{
    /**
     * @param InstanceManagerInterface $instanceManager
     * @return InstanceInterface
     */
    public function getActiveInstance(InstanceManagerInterface $instanceManager);

    /**
     * @param InstanceInterface $instance
     * @return void
     */
    public function switchInstance(InstanceInterface $instance);
}
