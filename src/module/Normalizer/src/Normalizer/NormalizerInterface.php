<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer;

use Normalizer\Entity\NormalizedInterface;

interface NormalizerInterface
{
    /**
     * @param object $object
     * @return NormalizedInterface
     * @throws Exception\InvalidArgumentException
     * @throws Exception\NoSuitableAdapterFoundException
     */
    public function normalize($object);
}
