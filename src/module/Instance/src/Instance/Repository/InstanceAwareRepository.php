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
namespace Instance\Repository;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use Instance\Manager\InstanceAwareEntityManager;

class InstanceAwareRepository extends EntityRepository
{
    /**
     * @var bool
     */
    protected $instanceFiltering = true;

    /**
     * @var string
     */
    protected $instanceField;

    /**
     * {@inheritDoc}
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        $query = parent::createQueryBuilder($alias, $indexBy);
        if ($this->instanceFiltering) {
            /* @var $entityManager InstanceAwareEntityManager */
            $entityManager = $this->_em;
            $query->andWhere(sprintf('%s.%s = :tenant', $alias, $this->instanceField));
            $query->setParameter('tenant', $entityManager->getInstance());
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
    {
        // Check identity map first
        if ($entity = $this->_em->getUnitOfWork()->tryGetById($id, $this->_class->rootEntityName)) {
            if (!($entity instanceof $this->_class->name)) {
                return null;
            }

            if ($lockMode != LockMode::NONE) {
                $this->_em->lock($entity, $lockMode, $lockVersion);
            }

            return $entity; // Hit!
        }

        if (!is_array($id) || count($id) <= 1) {
            // @todo FIXME: Not correct. Relies on specific order.
            $value = is_array($id) ? array_values($id) : array($id);
            $id    = array_combine($this->_class->identifier, $value);
        }

        $id = $this->addInstanceFilter($id);

        if ($lockMode == LockMode::NONE) {
            return $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName)->load($id);
        } else {
            if ($lockMode == LockMode::OPTIMISTIC) {
                if (!$this->_class->isVersioned) {
                    throw OptimisticLockException::notVersioned($this->_entityName);
                }
                $entity = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName)->load($id);

                $this->_em->getUnitOfWork()->lock($entity, $lockMode, $lockVersion);

                return $entity;
            } else {
                if (!$this->_em->getConnection()->isTransactionActive()) {
                    throw TransactionRequiredException::transactionRequired();
                }

                return $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName)->load(
                    $id,
                    null,
                    null,
                    array(),
                    $lockMode
                );
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findBy(
            $this->addInstanceFilter($criteria),
            $orderBy,
            $limit,
            $offset
        );
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria)
    {
        return parent::findOneBy($this->addInstanceFilter($criteria));
    }

    public function setInstanceField($field)
    {
        $this->instanceField = $field;
    }

    public function setInstanceFiltering($flag = true)
    {
        $this->instanceFiltering = $flag;
    }

    /**
     * @param array $criteria
     * @return array
     */
    protected function addInstanceFilter(array $criteria)
    {
        /* @var $entityManager InstanceAwareEntityManager */
        $entityManager = $this->_em;
        if ($this->instanceFiltering and $entityManager->getInstance()) {
            $criteria[$this->instanceField] = $entityManager->getInstance()->getId();
        }

        return $criteria;
    }
}