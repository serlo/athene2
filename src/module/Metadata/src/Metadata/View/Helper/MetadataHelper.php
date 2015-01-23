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
namespace Metadata\View\Helper;

use Common\Filter\PreviewFilter;
use Metadata\Entity\MetadataInterface;
use Metadata\Manager\MetadataManagerInterface;
use Uuid\Entity\UuidInterface;
use Zend\View\Helper\AbstractHelper;

class MetadataHelper extends AbstractHelper
{
    /**
     * @var MetadataManagerInterface
     */
    protected $metadataManager;

    /**
     * @param MetadataManagerInterface $metadataManager
     */
    public function __construct(MetadataManagerInterface $metadataManager)
    {
        $this->metadataManager = $metadataManager;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param UuidInterface $object
     * @param array         $keys
     * @param string        $separator
     * @return $this
     */
    public function keywords(UuidInterface $object, array $keys = [], $separator = ', ')
    {
        $data = [];
        if (!empty($keys)) {
            $metadata = [];
            foreach ($keys as $key) {
                $metadata[] = implode($this->metadataManager->findMetadataByObjectAndKey($object, $key), $separator);
            }
        } else {
            $metadata = $this->metadataManager->findMetadataByObject($object);
        }

        foreach ($metadata as $object) {
            /* @var $object MetadataInterface */
            $data[] = $object->getValue();
        }

        $filter = new PreviewFilter(250);
        $data   = implode($data, $separator);
        $data   = $filter->filter($data);
        $this->getView()->headMeta()->setProperty('keywords', $data);

        return $this;
    }
}
