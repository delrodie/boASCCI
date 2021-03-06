<?php

namespace AppBundle\Repository;

/**
 * RegionpresentationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegionpresentationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     *recherche de la presentation correspondante à la region
     *
     * author: Delrodie AMOIKON
     * date: 08/02/2018 19:49
     * version v1.1
     */
    public function findPresentationBy($slug)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQuery('
                        SELECT p, r
                        FROM AppBundle:Regionpresentation p
                        LEFT JOIN p.region r
                        WHERE r.slug = :slug
                        AND p.statut = 1
                        ORDER BY p.id DESC
                    ')
                ->setParameter('slug', $slug)
                ->setMaxResults(1);
        ;
        if (!$qb->getResult()){
           return  $qb = [];
        } else{
            return $qb->getSingleResult();
        }
    }
}
