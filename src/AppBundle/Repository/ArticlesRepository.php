<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

/**
 * ArticlesRepository
 *
 */
class ArticlesRepository extends EntityRepository
{
    /**
     * @param $page
     * @param int $perPage
     * 
     * @return Paginator
     */
    public function getAllArticles($page, $perPage = 10 )
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery();

        $query->getResult();
        return $this->paginate($query, $page, $perPage);
    }

    /**
     * @param $dql
     * @param $page
     * @param $limit
     * 
     * @return Paginator
     */
    private function paginate($dql, $page, $limit)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit
        return $paginator;
    }

}
