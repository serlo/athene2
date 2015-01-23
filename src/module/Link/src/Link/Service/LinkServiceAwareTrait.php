<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Link\Service;

trait LinkServiceAwareTrait
{

    /**
     * @var LinkServiceInterface
     */
    protected $linkService;

    /**
     * @return LinkServiceInterface
     *         $linkService
     */
    public function getLinkService()
    {
        return $this->linkService;
    }

    /**
     * @param LinkServiceInterface $linkService
     * @return self
     */
    public function setLinkService(LinkServiceInterface $linkService)
    {
        $this->linkService = $linkService;

        return $this;
    }
}
