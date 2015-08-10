<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Link\Options;

interface LinkOptionsInterface
{

    /**
     * @param string $type
     * @return bool
     */
    public function isParentAllowed($type);

    /**
     * @param string $type
     * @return bool
     */
    public function isChildAllowed($type);

    /**
     * @param string $type
     * @return bool
     */
    public function allowsManyParents($type);

    /**
     * @param string $type
     * @return bool
     */
    public function allowsManyChildren($type);

    /**
     * @return string
     */
    public function getLinkType();

    /**
     * @param string $type
     * @return string
     */
    public function getPermission($type);
}
