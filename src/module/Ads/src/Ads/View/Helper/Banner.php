<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\View\Helper;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

class Banner extends AbstractHelper
{
    use \Ads\Manager\AdsManagerAwareTrait;
    use \Instance\Manager\InstanceManagerAwareTrait;

    protected $ads;


    /**
     * @var \Zend\Http\Request
     */
    protected $request;

    public function __construct(

        Request $request) {
        $this->request = $request;
    }

    public function __invoke()
    {
        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $this->ads = $this->getAdsManager()->findShuffledAds($instance, 1, true);

        if(!$this->request->isXmlHttpRequest()) {
            return $this->getView()->partial(
                'ads/helper/banner-helper',
                [
                    'ads' => $this->ads
                ]
            );
        } else {
            return '';
        }
    }
}
