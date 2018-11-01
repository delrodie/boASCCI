<?php

namespace AppBundle\Repository;

/**
 * MaintenanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MaintenanceRepository extends \Doctrine\ORM\EntityRepository
{
    public function existMaintenance()
    {
        return $this->createQueryBuilder('m')
                    ->where('m.datefin > :date')
                    ->andWhere('m.statut = 1')
                    ->setParameter('date', date('Y/m/d', time()))
                    ->getQuery()->getResult()
            ;
    }
}
