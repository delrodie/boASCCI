<?php

namespace AppBundle\Repository;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function findSimilaire($categorie, $slug, $limit = null, $offset = null)
    {
        return $this->createQueryBuilder('p')
                    ->leftJoin('p.categorie', 'g')
                    ->where('g.slug = :categorie')
                    ->andWhere('p.slug <> :slug')
                    ->orderBy('p.id', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameters(array(
                        'categorie' => $categorie,
                        'slug' => $slug
                    ))
                    ->getQuery()->getResult()
            ;
    }
}
