<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search\Adapter;

use Common\ObjectManager\Flushable;
use Search\Entity;
use Zend\Paginator\Paginator;

interface AdapterInterface extends Flushable
{

    /**
     * @param Entity\DocumentInterface $solrDocument
     * @return void
     */
    public function add(Entity\DocumentInterface $solrDocument);

    /**
     * Deletes an object by it's id
     *
     * @param int $id
     * @return void
     */
    public function delete($id);

    /**
     * Deletes all entries from the index
     *
     * @return void
     */
    public function erase();

    /**
     * @param string $query
     * @return Paginator
     */
    public function search($query);
}
