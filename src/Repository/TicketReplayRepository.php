<?php

namespace App\Repository;

use App\Entity\TicketReplay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TicketReplay>
 *
 * @method TicketReplay|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketReplay|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketReplay[]    findAll()
 * @method TicketReplay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketReplayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketReplay::class);
    }

//    /**
//     * @return TicketReplay[] Returns an array of TicketReplay objects
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

//    public function findOneBySomeField($value): ?TicketReplay
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
