<?php

namespace App\Repository;

use App\Entity\LieuNaissances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LieuNaissances>
 */
class LieuNaissancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LieuNaissances::class);
    }
    public function save(LieuNaissances $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(LieuNaissances $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByAll(): array
    {
        return $this->createQueryBuilder('l')
            ->addSelect('c','ce','r') // Charge toutes les relations
            ->leftJoin('l.commune', 'c') // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('c.cercle', 'ce') // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('ce.region', 'r') // <-- Remplacer innerJoin par leftJoin
            ->orderBy('r.id', 'ASC')
            ->addOrderBy('ce.id', 'ASC')
            ->addOrderBy('c.id', 'ASC')
            ->addOrderBy('l.id', 'ASC')
            ->getQuery()
            ->enableResultCache(3600, 'lieu_naissances_list') // Clé explicite
            ->getResult();
    }

    //    /**
    //     * @return LieuNaissances[] Returns an array of LieuNaissances objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LieuNaissances
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
