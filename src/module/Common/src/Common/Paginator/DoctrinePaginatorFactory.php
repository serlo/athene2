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
namespace Common\Paginator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\Paginator\Paginator as ZendPaginator;

/**
 * @category   Zend
 * @package    Paginator
 */
class DoctrinePaginatorFactory
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPaginator($dql, $page, $limit)
    {
        $offset        = ($page - 1) * $limit;
        $query         = $this->entityManager->createQuery($dql)->setMaxResults($limit)->setFirstResult($offset);
        $paginator     = new Paginator($query);
        $adapter       = new DoctrinePaginatorAdapter($paginator);
        $zendPaginator = new ZendPaginator($adapter);
        $zendPaginator->setCurrentPageNumber($page);
        $zendPaginator->setItemCountPerPage($limit);
        return $zendPaginator;
    }
}
