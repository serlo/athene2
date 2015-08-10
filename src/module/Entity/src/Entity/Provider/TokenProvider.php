<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Provider;

use Entity\Entity\EntityInterface;
use Normalizer\NormalizerAwareTrait;
use Normalizer\NormalizerInterface;
use Taxonomy\Strategy\BranchDecisionMakerStrategy;
use Taxonomy\Strategy\ShortestBranchDecisionMaker;
use Token\Provider\AbstractProvider;
use Token\Provider\ProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class TokenProvider extends AbstractProvider implements ProviderInterface
{
    use ServiceLocatorAwareTrait, NormalizerAwareTrait;

    /**
     * @var BranchDecisionMakerStrategy
     */
    protected $strategy;

    public function __construct(NormalizerInterface $normalizer, BranchDecisionMakerStrategy $strategy = null)
    {
        if (!$strategy) {
            $strategy = new ShortestBranchDecisionMaker();
        }
        $this->normalizer = $normalizer;
        $this->strategy   = $strategy;
    }

    public function getData()
    {
        $term = $this->strategy->findBranch($this->getObject()->getTaxonomyTerms());

        $path = $this->getObject()->getId();

        if ($term) {
            $path = [];
            while ($term->hasParent()) {
                $path[] = $term->getName();
                $term = $term->getParent();
            }
            $path = array_reverse($path);
            $path = implode('/', $path);
        }

        $normalized = $this->getNormalizer()->normalize($this->getObject());
        $title      = $normalized->getTitle();

        return [
            'path'  => $path,
            'title' => $title,
            'id'    => $this->getObject()->getId(),
        ];
    }

    protected function isValid(EntityInterface $object)
    {
    }

    protected function validObject($object)
    {
        $this->isValid($object);
    }
}
