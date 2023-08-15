<?php

namespace App\Repository;

use App\Entity\SiteClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiteClient>
 *
 * @method SiteClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteClient[]    findAll()
 * @method SiteClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteClient::class);
    }

    public function getSitesList(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        select site_client.id,nom_plan,nom_site,domaine_site,type_site,email,concat(nomClient,' ',prenomClient) as nomComplet from site_client
         inner join client on client.id=site_client.id_client 
         inner join plan on plan.id=site_client.id_plan
         
            ";

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return SiteClient[] Returns an array of SiteClient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SiteClient
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
