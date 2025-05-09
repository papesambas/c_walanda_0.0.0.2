<?php

namespace App\Repository;

use App\Entity\Ninas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ninas>
 */
class NinasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ninas::class);
    }
    public function add(Ninas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(Ninas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByAll(): array
    {
        return $this->createQueryBuilder('n')
            ->addSelect('p', 'prp', 'm', 'prm') // Charge toutes les relations
            ->leftJoin('n.peres', 'p')          // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('p.profession', 'prp')
            ->leftJoin('n.meres', 'm')          // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('m.profession', 'prm')
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->enableResultCache(3600, 'ninas_list') // Clé explicite
            ->getResult();
    }


    //    /**
    //     * @return Ninas[] Returns an array of Ninas objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ninas
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
