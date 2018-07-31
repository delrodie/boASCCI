<?php

namespace AppBundle\Repository;

/**
 * RadioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RadioRepository extends \Doctrine\ORM\EntityRepository
{
    public function findListDesc()
    {
        return $this->createQueryBuilder('r')
                    ->orderBy('r.id', 'DESC')
                    ->getQuery()->getResult()
        ;
    }

    /**
     * La derniere emission radion 
     */
    public function findLatestRadio($limit, $offset)
    {
        return $this->createQueryBuilder('r')
                    ->where('r.statut = 1')
                    ->orderBy('r.id', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getQuery()->getOneOrNullResult()
        ;
    }
}