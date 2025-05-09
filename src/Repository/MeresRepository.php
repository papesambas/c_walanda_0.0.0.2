<?php

namespace App\Repository;

use App\Entity\Meres;
use App\Data\SearchParentData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Meres>
 */
class MeresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meres::class);
    }

    public function add(Meres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(Meres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Summary of findByAll
     * @return array
     */
    public function findByAll(): array
    {
        return $this->createQueryBuilder('m')
            ->addSelect('p', 't1', 't2','n','pren') // Charge toutes les relations
            ->leftJoin('m.profession', 'p') // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('m.telephone1', 't1') // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('m.telephone2', 't2') // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('m.nom', 'n') // <-- Remplacer innerJoin par leftJoin
            ->leftJoin('m.prenom', 'pren') // <-- Remplacer innerJoin par leftJoin
            ->orderBy('n.designation', 'ASC')
            ->addOrderBy('pren.designation', 'ASC')
            //->addOrderBy('m.fullname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findBySearchParentData(SearchParentData $searchParentData)
    {
        // Si SearchParentData est null ou que ses propriétés sont vides, retourner une liste vide
        if (
            $searchParentData === null ||
            (empty($searchParentData->qMere) && empty($searchParentData->telephoneMere) && empty($searchParentData->ninaMere))
        ) {
            return [];
        }
    
        $queryBuilder = $this->createQueryBuilder('m')
            ->leftJoin('m.telephone1', 't1')
            ->leftJoin('m.telephone2', 't2')
            ->leftJoin('m.ninas', 'n')
            ->addSelect('t1', 't2', 'n');
    
        // Recherche par fullname (insensible à la casse)
        if (!empty($searchParentData->qMere)) {
            $searchTerm = trim($searchParentData->qMere); // Supprimer les espaces inutiles
            $queryBuilder
                ->andWhere('LOWER(m.fullname) LIKE LOWER(:fullname)')
                ->setParameter('fullname', '%' . $searchTerm . '%')
                ;
        }
    
        // Recherche par téléphone
        if (!empty($searchParentData->telephoneMere)) {
            $normalizedTelephone = preg_replace('/\D/', '', $searchParentData->telephoneMere);
            $queryBuilder
                ->andWhere('t1.numero LIKE :telephoneMere OR t2.numero LIKE :telephoneMere')
                ->setParameter('telephoneMere', '%' . $normalizedTelephone . '%');
        }
    
        // Recherche par NINA
        if (!empty($searchParentData->ninaMere)) {
            $queryBuilder
                ->andWhere('n.designation LIKE :ninaMere')
                ->setParameter('ninaMere', '%' . $searchParentData->ninaMere . '%');
        }
    
        return $queryBuilder->getQuery()->getResult();
    }     

    //    /**
    //     * @return Meres[] Returns an array of Meres objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Meres
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
