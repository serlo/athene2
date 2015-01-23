<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
