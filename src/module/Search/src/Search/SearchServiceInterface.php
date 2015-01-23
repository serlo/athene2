<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search;

use Common\ObjectManager\Flushable;
use Zend\Paginator\Paginator;

interface SearchServiceInterface extends Flushable
{
    /**
     * @param object $object
     * @return void
     * @throws \Exception
     */
    public function add($object);

    /**
     * Deletes an object
     *
     * @param object $object
     * @return void
     */
    public function delete($object);

    /**
     * Deletes all entries from the index
     *
     * @return void
     */
    public function erase();

    /**
     * Rebuilds the index
     *
     * @return void
     */
    public function rebuild();

    /**
     * @param string $query
     * @param int    $page
     * @param int    $itemsPerPage
     * @return Paginator
     */
    public function search($query, $page = 0, $itemsPerPage = 20);
}