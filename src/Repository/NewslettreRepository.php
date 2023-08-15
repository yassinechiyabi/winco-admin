<?php

namespace App\Repository;

use App\Entity\Newslettre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Newslettre>
 *
 * @method Newslettre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newslettre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newslettre[]    findAll()
 * @method Newslettre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewslettreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newslettre::class);
    }

//    /**
//     * @return Newslettre[] Returns an array of Newslettre objects
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

//    public function findOneBySomeField($value): ?Newslettre
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
