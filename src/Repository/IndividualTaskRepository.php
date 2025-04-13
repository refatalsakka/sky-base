<?php

namespace App\Repository;

use App\Entity\IndividualTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IndividualTask>
 */
class IndividualTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndividualTask::class);
    }

    public function findWithIndividualCount(?int $unitId = null, ?int $militaryRankId = null): array
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t.id, t.task, COUNT(i.id) AS individualCount')
            ->leftJoin('t.individuals', 'i')
            ->groupBy('t.id')
            ->orderBy('t.task', 'ASC');

        if ($unitId !== null) {
            $qb->andWhere('i.unit = :unitId')->setParameter('unitId', $unitId);
        }

        if ($militaryRankId !== null) {
            $qb->andWhere('i.militaryRank = :militaryRankId')->setParameter('militaryRankId', $militaryRankId);
        }

        return $qb->getQuery()->getArrayResult();
    }

    //    /**
    //     * @return IndividualTask[] Returns an array of IndividualTask objects
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

    //    public function findOneBySomeField($value): ?IndividualTask
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
