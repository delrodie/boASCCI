<?php

namespace AppBundle\Repository;

/**
 * RegionaleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegionaleRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Recherche des trois dernières actualités régionales
     * 
     * author: Delrodie AMOIKON
     * date: 20/01/2018 01:35
     */
    public function findLastRegionale($offset, $limit)
    {
        $em = $this->getEntityManager();
        return $qb = $em->createQuery('
                            SELECT r, t
                            FROM AppBundle:Regionale r
                            LEFT JOIN r.region t
                            WHERE r.statut = :actif
                            ORDER BY r.id DESC
                        ')
                        ->setFirstResult($offset)
                        ->setMaxresults($limit)
                        ->setParameter('actif', 1)
                        ->getResult()
                        ;
    }

    /**
     * Recherche des trois dernières actualités sans la concernée
     * 
     * author: Delrodie AMOIKON
     * date: 20/01/2018 02:54
     */
    public function findThreeLastRegionale($slug, $offset, $limit)
    {
        $em = $this->getEntityManager();
        return $qb = $em->createQuery('
                            SELECT a, t
                            FROM AppBundle:Regionale a
                            LEFT JOIN a.region t
                            WHERE a.statut = :actif
                            AND a.slug <> :slug
                            ORDER BY a.id DESC
                        ')
                        ->setFirstResult($offset)
                        ->setMaxresults($limit)
                        ->setParameters(array(
                            'actif' => 1,
                            'slug'  => $slug
                        ))
                        ->getResult()
                        ;
    }
}
