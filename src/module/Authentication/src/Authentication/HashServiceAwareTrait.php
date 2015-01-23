<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Authentication;

trait HashServiceAwareTrait
{

    /**
     * @var HashServiceInterface
     */
    protected $hashService;

    /**
     * @return HashServiceInterface $hashService
     */
    public function getHashService()
    {
        return $this->hashService;
    }

    /**
     * @param HashServiceInterface $hashService
     * @return self
     */
    public function setHashService(HashServiceInterface $hashService)
    {
        $this->hashService = $hashService;
        return $this;
    }
}
