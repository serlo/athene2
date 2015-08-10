<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace License\Entity;

use Instance\Entity\InstanceAwareInterface;

interface LicenseInterface extends InstanceAwareInterface
{

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getIconHref();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $content
     * @return void
     */
    public function setContent($content);

    /**
     * @param string $iconHref
     * @return void
     */
    public function setIconHref($iconHref);

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * @param string $url
     * @return void
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getAgreement();

    /**
     * @param string $agreement
     * @return void
     */
    public function setAgreement($agreement);

    /**
     * @return boolean
     */
    public function isDefault();

    /**
     * @param boolean $default
     */
    public function setDefault($default);
}
