<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Navigation\Entity;

use Instance\Entity\InstanceAwareInterface;
use Type\Entity\TypeAwareInterface;

interface ContainerInterface extends InstanceAwareInterface, TypeAwareInterface
{
    /**
     * @param PageInterface $page
     * @return void
     */
    public function addPage(PageInterface $page);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return PageInterface[]
     */
    public function getPages();

    /**
     * @param PageInterface $page
     * @return void
     */
    public function removePage(PageInterface $page);
}
