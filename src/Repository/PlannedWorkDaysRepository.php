<?php

namespace App\Repository;

use App\Entity\PlannedWorkDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlannedWorkDays|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlannedWorkDays|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlannedWorkDays[]    findAll()
 * @method PlannedWorkDays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlannedWorkDaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlannedWorkDays::class);
    }

    // /**
    //  * @return PlannedWorkDays[] Returns an array of PlannedWorkDays objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlannedWorkDays
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
