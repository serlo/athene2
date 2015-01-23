<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use Normalizer\Entity\NormalizedInterface;

interface AdapterInterface
{
    /**
     * @param object $object
     * @return NormalizedInterface
     */
    public function normalize($object);

    /**
     * @param object $object
     * @return true
     */
    public function isValid($object);
}
