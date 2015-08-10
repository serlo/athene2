<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Entity;

trait InstanceAwareTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="Instance\Entity\Instance")
     * @ORM\JoinColumn(name="instance_id", referencedColumnName="id")
     * @var InstanceInterface
     */
    protected $instance;

    /**
     * @return InstanceInterface
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param InstanceInterface $instance
     */
    public function setInstance(InstanceInterface $instance)
    {
        $this->instance = $instance;
    }
}
