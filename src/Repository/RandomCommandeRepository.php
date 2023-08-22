<?php

namespace App\Repository;

use App\Entity\RandomCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RandomCommande>
 *
 * @method RandomCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method RandomCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method RandomCommande[]    findAll()
 * @method RandomCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RandomCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RandomCommande::class);
    }

//    /**
//     * @return RandomCommande[] Returns an array of RandomCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RandomCommande
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
