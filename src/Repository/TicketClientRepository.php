<?php

namespace App\Repository;

use App\Entity\TicketClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TicketClient>
 *
 * @method TicketClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketClient[]    findAll()
 * @method TicketClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketClient::class);
    }

    public function getAllTickets():Array{
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        select ticket_client.id as id,concat(nomClient,' ',prenomClient) as nomComplet,email,niveauUrgence,titre,nom_site,domaine_site,Etat
        from ticket_client
        inner join client on
        client.id=ticket_client.id_client
        inner join site_client on
        site_client.id=ticket_client.idSite
            ";

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return TicketClient[] Returns an array of TicketClient objects
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

//    public function findOneBySomeField($value): ?TicketClient
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
