<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RandomCommande;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RandomCommandeController extends AbstractController
{
    #[Route('api/RandomCommandesList/{token}', name: 'app_random_commande')]
    public function RandomCommandesList(EntityManagerInterface $entityManager,string $token): JsonResponse
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $RandomCommandeRepository = $entityManager->getRepository(RandomCommande::class);
        $randomCommandes=$RandomCommandeRepository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($randomCommandes, 'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
             }
         ]);
        return new jsonResponse($jsonContent);
    }
}
