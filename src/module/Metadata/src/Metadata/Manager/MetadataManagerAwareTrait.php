<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
