<?php

namespace AppBundle\Repository;

/**
 * PubliciteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PubliciteRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * La publicité encours 
     * 
     * Author: Delrodie AMOIKON 
     * Date: 27/01/2018 11:47
     */
    public function findPublicite($offset,$limit)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQuery('
                    SELECT p
                    FROM AppBundle:Publicite p
                    WHERE p.statut = :actif
                    AND p.datedeb >= :date
                    AND p.datefin >= :date
                    ORDER BY p.datedeb ASC
                    ')
                    ->setFirstResult($offset)
                    ->setMaxresults($limit)
                    ->setParameters(array(
                        'actif' => 1,
                        'date'  =>  date('Y-m-d', time())
                    ))
                    ->getResult()
                    ;
        return $qb;
    }
}
