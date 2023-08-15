<?php

namespace App\Repository;

use App\Entity\WincoCanadaContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WincoCanadaContact>
 *
 * @method WincoCanadaContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method WincoCanadaContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method WincoCanadaContact[]    findAll()
 * @method WincoCanadaContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WincoCanadaContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WincoCanadaContact::class);
    }

//    /**
//     * @return WincoCanadaContact[] Returns an array of WincoCanadaContact objects
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

//    public function findOneBySomeField($value): ?WincoCanadaContact
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
