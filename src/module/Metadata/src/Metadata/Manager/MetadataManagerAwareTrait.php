<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Metadata\Manager;

trait MetadataManagerAwareTrait
{

    /**
     * @var MetadataManagerInterface
     */
    protected $metadataManager;

    /**
     * @return MetadataManagerInterface $metadataManager
     */
    public function getMetadataManager()
    {
        return $this->metadataManager;
    }

    /**
     * @param MetadataManagerInterface $metadataManager
     * @return self
     */
    public function setMetadataManager(MetadataManagerInterface $metadataManager)
    {
        $this->metadataManager = $metadataManager;

        return $this;
    }
}
