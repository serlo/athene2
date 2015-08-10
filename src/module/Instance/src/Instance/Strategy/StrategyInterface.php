<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
