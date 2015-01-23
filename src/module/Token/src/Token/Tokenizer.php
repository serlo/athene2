<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Token;

use Token\Provider;

class Tokenizer implements TokenizerInterface
{
    use\Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     *
     * @var Provider\ProviderInterface
     */
    protected $provider;

    /**
     *
     * @return Provider\ProviderInterface $provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     *
     * @param ProviderInterface $provider            
     * @return self
     */
    protected function setProvider(Provider\ProviderInterface $provider)
    {
        $this->provider = $provider;
        return $this;
    }

    public function transliterate($provider, $object, $tokenString)
    {
        if (! is_object($provider)) {
            $provider = $this->getServiceLocator()->get($provider);
        }
        
        $this->setProvider($provider);
        $this->getProvider()->setObject($object);
        
        // WHY DO YOU NOT WORK WHEN { IS THE FIRST CHAR
        $tokenString = ':' . $tokenString;
        
        $returnString = $tokenString;
        
        $token = strtok($tokenString, '{');
        while ($token !== FALSE) {
            $token = strtok('}');
            $replace = '{' . $token . '}';
            $with = $this->transliterateToken($token);
            $limit = 1;
            $returnString = str_replace($replace, $with, $returnString, $limit);
            $token = strtok('{');
        }
        
        // WHY DO YOU NOT WORK WHEN { IS THE FIRST CHAR
        $return = substr($returnString, 1);
        return $return;
    }

    protected function transliterateToken($token)
    {
        $data = $this->getProvider()->getData();
        if (! array_key_exists($token, $data)) {
            throw new \Token\Exception\RuntimeException(sprintf('Token `%s` not provided by `%s`', $token, get_class($this->getProvider())));
        }
        return $data[$token];
    }
}
