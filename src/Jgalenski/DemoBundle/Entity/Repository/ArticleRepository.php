<?php
namespace Jgalenski\DemoBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException,
    Doctrine\ORM\Mapping\ClassMetadata,
    Doctirne\ORM\Query;
 
/**
 * This class give you method to reach query instead of result mapping into objects
 * 
 * @author jgalenski
 */
class ArticleRepository extends EntityRepository
{
    public function __construct($em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    /**
     * Finds all entities in the repository.
     *
     * @return Query
     */
    public function queryFindAll()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->from($this->_entityName, $this->_entityName);
        $qb->select($this->_entityName);

        return $qb->getQuery();
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Query
     */
    public function queryFindBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->from($this->_entityName, $this->_entityName);
        $qb->select($this->_entityName);

        foreach ($criteria as $key => $value) {
            $qb->andWhere($qb->expr()->eq($this->_entityName . '.' . $key, $value));
        }

        if (null !== $orderBy) {
            foreach ($orderBy as $key => $value) {
                $qb->addOrderBy($this->_entityName . '.' .$key, $value);
            }
        }

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        if (null !== $offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery();
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria
     * @return Query
     */
    public function queryFindOneBy(array $criteria)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->from($this->_entityName, $this->_entityName);
        $qb->select($this->_entityName);

        foreach ($criteria as $key => $value) {
            $qb->andWhere($qb->expr()->eq($this->_entityName . '.' . $key, $value));
        }

        $qb->setMaxResults(1);

        return $qb->getQuery();
    }
}