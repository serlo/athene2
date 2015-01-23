<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\View\Helper;

use Uuid\Entity\UuidInterface;
use Zend\View\Helper\AbstractHelper;

class RelatedContentHelper extends AbstractHelper
{
    use \RelatedContent\Manager\RelatedContentManagerAwareTrait;

    /**
     * @var UuidInterface
     */
    protected $object;

    /**
     * @return UuidInterface $object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param UuidInterface $object
     * @return self
     */
    public function setObject(UuidInterface $object)
    {
        $this->object = $object;
        return $this;
    }

    public function __invoke(UuidInterface $uuid)
    {
        $this->setObject($uuid);
        return $this->render();
    }

    protected function render()
    {
        $aggregated = $this->getRelatedContentManager()->aggregateRelatedContent(
            $this->getObject()->getId()
        );
        return $this->getView()->partial(
            'related-content/view',
            [
                'aggregated' => $aggregated
            ]
        );
    }
}
