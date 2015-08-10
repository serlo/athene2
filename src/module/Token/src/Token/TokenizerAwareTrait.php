<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Token;

trait TokenizerAwareTrait
{

    /**
     * @var TokenizerInterface
     */
    protected $tokenizer;

    /**
     * @return TokenizerInterface $tokenizer
     */
    public function getTokenizer()
    {
        return $this->tokenizer;
    }

    /**
     * @param TokenizerInterface $tokenizer
     * @return self
     */
    public function setTokenizer(TokenizerInterface $tokenizer)
    {
        $this->tokenizer = $tokenizer;
        return $this;
    }
}
