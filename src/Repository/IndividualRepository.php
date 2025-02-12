<?php

namespace App\Repository;

use App\Entity\Individual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Individual>
 */
class IndividualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Individual::class);
    }

    //    /**
    //     * @return Individual[] Returns an array of Individual objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Individual
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByMilitaryRankCode(string $code): array
    {
        return $this->createQueryBuilder('i')
            ->join('i.militaryRank', 'm')
            ->where('m.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getResult();
    }

    public function findByUnitAndMilitaryRank(int $unitId, string $militaryRankCode): array
    {
        return $this->createQueryBuilder('i')
            ->join('i.militaryRank', 'mr')
            ->where('i.unit = :unitId')
            ->andWhere('mr.code = :rankCode')
            ->setParameter('unitId', $unitId)
            ->setParameter('rankCode', $militaryRankCode)
            ->getQuery()
            ->getResult();
    }
}
