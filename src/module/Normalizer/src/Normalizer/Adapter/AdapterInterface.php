<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use Normalizer\Entity\NormalizedInterface;
use Zend\I18n\Translator\TranslatorInterface;

interface AdapterInterface
{
    /**
     * @param object $object
     * @return NormalizedInterface
     */
    public function normalize($object);

    /**
     * @param TranslatorInterface $translator
     * @return void
     */
    public function setTranslator($translator);

    /**
     * @param object $object
     * @return true
     */
    public function isValid($object);
}
