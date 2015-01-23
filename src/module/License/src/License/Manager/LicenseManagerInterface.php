<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace License\Manager;

use Common\ObjectManager\Flushable;
use Instance\Entity\InstanceInterface;
use License\Entity\LicenseAwareInterface;
use License\Entity\LicenseInterface;
use License\Form\LicenseForm;

interface LicenseManagerInterface extends Flushable
{

    /**
     * @param int $id
     * @return LicenseInterface
     */
    public function getLicense($id);

    /**
     * @param LicenseForm $form
     * @return LicenseInterface
     */
    public function createLicense(LicenseForm $form);

    /**
     * @param int $id
     * @return void
     */
    public function removeLicense($id);

    /**
     * @return LicenseInterface[]
     */
    public function findAllLicenses();

    /**
     * @param LicenseForm $form
     * @return void
     */
    public function updateLicense(LicenseForm $form);

    /**
     * @param int $id
     * @return LicenseForm
     */
    public function getLicenseForm($id = null);

    /**
     * @param LicenseAwareInterface $object
     * @param LicenseInterface      $license
     * @return void
     */
    public function injectLicense(LicenseAwareInterface $object, LicenseInterface $license = null);

    /**
     * @return LicenseInterface
     */
    public function getDefaultLicense();
}
