<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Instance\Entity;

interface InstanceAwareInterface extends InstanceProviderInterface
{
    /**
     * @param InstanceInterface $instance
     * @return self
     */
    public function setInstance(InstanceInterface $instance);
}
