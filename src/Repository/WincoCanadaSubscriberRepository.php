<?php

namespace App\Repository;

use App\Entity\WincoCanadaSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WincoCanadaSubscriber>
 *
 * @method WincoCanadaSubscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method WincoCanadaSubscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method WincoCanadaSubscriber[]    findAll()
 * @method WincoCanadaSubscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WincoCanadaSubscriberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WincoCanadaSubscriber::class);
    }

//    /**
//     * @return WincoCanadaSubscriber[] Returns an array of WincoCanadaSubscriber objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WincoCanadaSubscriber
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
