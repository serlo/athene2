<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\Manager;

trait UuidManagerAwareTrait
{
    /**
     * @var UuidManagerInterface
     */
    protected $uuidManager;

    /**
     * @return UuidManagerInterface $uuidManager
     */
    public function getUuidManager()
    {
        return $this->uuidManager;
    }

    /**
     * @param UuidManagerInterface $uuidManager
     * @return self
     */
    public function setUuidManager(UuidManagerInterface $uuidManager)
    {
        $this->uuidManager = $uuidManager;

        return $this;
    }
}
