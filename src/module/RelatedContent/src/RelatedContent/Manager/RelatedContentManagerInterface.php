<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Manager;

use Doctrine\Common\Collections\Collection;
use RelatedContent\Entity;

interface RelatedContentManagerInterface
{

    /**
     *
     * @param int $id            
     * @return Collection
     */
    public function aggregateRelatedContent($id);

    /**
     *
     * @param int $id            
     * @return Entity\ContainerInterface
     */
    public function getContainer($id);

    /**
     *
     * @param int $container            
     * @param string $title            
     * @param string $url            
     * @return Entity\ExternalInterface
     */
    public function addExternal($container, $title, $url);

    /**
     *
     * @param int $container            
     * @param string $title            
     * @return Entity\CategoryInterface
     */
    public function addCategory($container, $title);

    /**
     *
     * @param int $container            
     * @param string $title            
     * @param int $related            
     * @return Entity\InternalInterface
     */
    public function addInternal($container, $title, $related);

    /**
     *
     * @param int $id            
     * @return self
     */
    public function removeRelatedContent($id);

    /**
     *
     * @param int $holder            
     * @param int $position            
     * @return self
     */
    public function positionHolder($holder, $position);
}
