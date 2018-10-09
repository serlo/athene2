<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\Manager;

use Common\ObjectManager\Flushable;
use Doctrine\Common\Collections\Collection;
use Uuid\Entity\UuidInterface;
use Zend\Paginator\Paginator;

interface UuidManagerInterface extends Flushable
{
    /**
     * Finds all Uuids
     * <code>
     *    $collection = $um->findAll();
     * </code>
     *
     * @return UuidInterface[]|Collection
     */
    public function findAll();

    /**
     * Finds Uuids by their trashed attribute.
     * <code>
     * $uuids = $um->findByTrashed(true);
     * foreach($uuids as $uuid)
     * {
     *    echo $uuid->getId();
     * }
     * </code>
     *
     * @param bool $trashed
     * @param int $page
     * @return Paginator
     */
    public function findByTrashed($trashed, $page);

    /**
     * Get an Uuid.
     * <code>
     * $um->getUuid('1');
     * $um->getUuid('someH4ash');
     * $um->getUuid($uuidEntity);
     * </code>
     *
     * @param int|string|UuidInterface $key
     * @param bool                     $bypassIsolation
     * @return UuidInterface $uuid
     */
    public function getUuid($key, $bypassIsolation = false);

    /**
     * @param int $id
     * @return void
     */
    public function purgeUuid($id);

    /**
     * @param int $id
     * @return void
     */
    public function restoreUuid($id);

    /**
     * @param int $id
     * @return void
     */
    public function trashUuid($id);
}
