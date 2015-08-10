<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Horizon extends AbstractHelper
{
    use \Ads\Manager\AdsManagerAwareTrait;
    use \Instance\Manager\InstanceManagerAwareTrait;

    protected $ads;

    public function __invoke($number)
    {
        $instance  = $this->getInstanceManager()->getInstanceFromRequest();
        $this->ads = $this->getAdsManager()->findShuffledAds($instance, $number);

        return $this->getView()->partial(
            'ads/helper/ads-helper',
            [
                'ads' => $this->ads,
            ]
        );
    }
}
