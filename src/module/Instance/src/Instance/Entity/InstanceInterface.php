<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
