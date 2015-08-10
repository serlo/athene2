<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
