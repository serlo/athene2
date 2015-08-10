<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Ads\Manager;

trait AdsManagerAwareTrait
{

    /**
     * @var AdsManagerInterface
     */
    protected $adsManager;

    /**
     * @return AdsManagerInterface
     */
    public function getAdsManager()
    {
        return $this->adsManager;
    }

    /**
     * @param AdsManagerInterface $adsManager
     * @return $this
     */
    public function setAdsManager(AdsManagerInterface $adsManager)
    {
        $this->adsManager = $adsManager;

        return $this;
    }
}
