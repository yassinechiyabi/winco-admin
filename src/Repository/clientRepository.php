<?php

namespace App\Repository;

use App\Entity\client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class clientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, client::class);
    }

    public function ClientTableList():Array{
        $conn = $this->getEntityManager()->getConnection();
        $query="
        select client.phone as phone,client.id id,nomClient,prenomClient,email,count(commande.id_client) nbrCommande,COUNT(site_client.id_client) nbrSite,COUNT(ticket_client.id_client) nbrTicket,DATE(client.created_at) createAt  from client
        left join commande on commande.id_client=client.id 
        left join site_client on site_client.id_client=client.id
        left JOIN ticket_client on ticket_client.id=client.id group by client.id
        ";
        $resultSet = $conn->executeQuery($query);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
        
    }
}
