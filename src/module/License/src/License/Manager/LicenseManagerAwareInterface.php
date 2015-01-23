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

interface LicenseManagerAwareInterface
{

    /**
     * @return LicenseManagerInterface $licenseManager
     */
    public function getLicenseManager();

    /**
     * @param LicenseManagerInterface $licenseManager
     * @return self
     */
    public function setLicenseManager(LicenseManagerInterface $licenseManager);
}
