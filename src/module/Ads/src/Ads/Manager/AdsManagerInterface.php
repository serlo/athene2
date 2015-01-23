<?php
namespace Ads\Manager;

use Ads\Entity\AdInterface;
use Common\ObjectManager\Flushable;
use Instance\Entity\InstanceInterface;

interface AdsManagerInterface extends Flushable
{
    /**
     * @param numeric $id
     * @return AdInterface
     */
    public function getAd($id);

    /**
     * @param array       $data
     * @param AdInterface $ad
     * @return AdInterface
     */
    public function updateAd(array $data, AdInterface $ad);

    /**
     * @param AdInterface $ad
     * @return void
     */
    public function removeAd(AdInterface $ad);


    /**
     * @param InstanceInterface $instance
     * @param numeric           $number
     * @return array
     */
    public function findShuffledAds(InstanceInterface $instance, $number);

    /**
     * @param array $data
     * @return AdInterface
     */
    public function createAd(array $data);

    /**
     * @param InstanceInterface $instance
     * @return AdInterface
     */
    public function findAllAds(InstanceInterface $instance);

    /**
     * @param AdInterface|int $id
     * @return void
     */
    public function clickAd($id);
}
