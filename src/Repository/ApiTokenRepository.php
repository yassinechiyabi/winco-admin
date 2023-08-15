<?php

namespace App\Repository;

use App\Entity\ApiToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiToken>
 *
 * @method ApiToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiToken[]    findAll()
 * @method ApiToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToken::class);
    }

    public function findToken(string $token):Array{
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        select count(*) as compteur from api_token where token like '".$token."' and is_active=1
            ";

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function desctivateAllTokens(int $idUser){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        update api_token set is_active=0 where id_user=".$idUser.
            "";

        $resultSet = $conn->executeQuery($sql);

    }

    public function flagToken(string $token){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        update api_token set is_active=0 where token like '".$token.
            "'";

        $resultSet = $conn->executeQuery($sql);
    }

//    /**
//     * @return ApiToken[] Returns an array of ApiToken objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ApiToken
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
