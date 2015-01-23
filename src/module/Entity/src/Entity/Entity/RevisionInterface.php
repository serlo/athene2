<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity\Entity;

use DateTime;
use Instance\Entity\InstanceProviderInterface;
use User\Entity\UserInterface;
use Versioning\Entity\RevisionInterface as VersioningRevision;

interface RevisionInterface extends VersioningRevision, InstanceProviderInterface
{

    /**
     * Gets the date
     *
     * @return DateTime
     */
    public function getTimestamp();

    /**
     * Gets the author
     *
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * Sets the date
     *
     * @param DateTime $date
     * @return self
     */
    public function setTimestamp(DateTime $date);

    /**
     * @param string $field
     * @param string $default
     * @return string
     */
    public function get($field, $default = null);

    /**
     * @param string $name
     * @param string $value
     * @return RevisionField
     */
    public function set($name, $value);

    /**
     * @return RevisionField[]
     */
    public function getFields();
}
