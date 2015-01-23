<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Normalizer\Entity;

use DateTime;

interface MetadataInterface
{
    /**
     * @return string
     */
    public function getAuthor();

    /**
     * @return string
     */
    public function getContext();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return DateTime
     */
    public function getCreationDate();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getLanguageCode();

    /**
     * @return string
     */
    public function getLicense();

    /**
     * @return DateTime
     */
    public function getLastModified();

    /**
     * @return array|string[]
     */
    public function getKeywords();
}
