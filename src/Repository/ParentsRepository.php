<?php

namespace App\Repository;

use App\Entity\Parents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parents>
 */
class ParentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parents::class);
    }

    public function add(Parents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(Parents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByAll(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.pere', 'pere')
            ->leftJoin('pere.profession', 'pere_profession')
            ->leftJoin('pere.telephone1', 'pere_tel1')
            ->leftJoin('pere.telephone2', 'pere_tel2')
            ->leftJoin('p.mere', 'mere')
            ->leftJoin('mere.profession', 'mere_profession')
            ->leftJoin('mere.telephone1', 'mere_tel1')
            ->leftJoin('mere.telephone2', 'mere_tel2')
            ->addSelect('pere', 'pere_profession', 'pere_tel1', 'pere_tel2', 'mere', 'mere_profession', 'mere_tel1', 'mere_tel2')
            ->addOrderBy('pere.fullname', 'ASC')
            ->addOrderBy('mere.fullname', 'ASC')
            ->addOrderBy('p.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Parents[] Returns an array of Parents objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Parents
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
