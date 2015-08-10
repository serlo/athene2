<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Instance\Entity;

interface InstanceInterface
{

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return int $id
     */
    public function getId();

    /**
     * @return LanguageInterface
     */
    public function getLanguage();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getSubdomain();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);
}
