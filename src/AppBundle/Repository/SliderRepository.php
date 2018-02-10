<?php

namespace AppBundle\Repository;

/**
 * SliderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SliderRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste des cinq premiers slides 
     * 
     * author: Delrodie AMOIKON 
     * date: 19/01/2018 17:40
     */
    public function findSlideStandard($offset, $limit)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQuery('
                    SELECT s
                    FROM AppBundle:Slider s
                    WHERE s.statut = :actif
                    ORDER BY s.id ASC
                ')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->setParameter('actif', 1)
                ->getResult();
                ;
        return $qb;
    }

    /**
     * Le dernier slide actif 
     * 
     * author: Delrodie AMOIKON
     * date: 19/01/2018 17:51
     */
    public function findOneSlide($offset, $limit)
    {
        $qb = $this->createQueryBuilder('s')
                    ->where('s.statut = 1')
                    ->andWhere('s.datedebut < :date')
                    ->andWhere('s.datefin >= :date')
                    ->andWhere('s.id > :offset')
                    ->orderBy('s.datedebut', 'DESC')
                    //->setFirstResult($offset)
                    ->setMaxresults($limit)
                    ->setParameters(array(
                        'date' => date('Y-m-d', time()),
                        'offset'   => $offset,
                    ))
                    ->getQuery()->getResult();
        return $qb;
    }
}
