<?php

namespace App\Repository;

use App\Entity\Telephones1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Telephones1>
 */
class Telephones1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telephones1::class);
    }

    /**
     * Summary of findByAll
     * @return array
     */
    public function findByAll(): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('p', 'prp', 'm', 'prm') // Charge toutes les relations
            ->leftJoin('t.peres', 'p')          // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('p.profession', 'prp')
            ->leftJoin('t.meres', 'm')          // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('m.profession', 'prm')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->enableResultCache(3600, 'telephones1_list') // Clé explicite
            ->getResult();
    }

    //    /**
    //     * @return Telephones1[] Returns an array of Telephones1 objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Telephones1
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
