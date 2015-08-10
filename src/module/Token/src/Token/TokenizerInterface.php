<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Token;

interface TokenizerInterface
{

    /**
     * @param string $provider
     * @param object $object
     * @param string $tokenString
     * @return $string
     */
    public function transliterate($provider, $object, $tokenString);

    /**
     * @return Provider\ProviderInterface $provider
     */
    public function getProvider();
}
