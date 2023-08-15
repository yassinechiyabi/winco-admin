<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Review;
use App\Entity\WincoCanadaContact;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReviewController extends AbstractController
{
    #[Route('api/getallReviews/{token}', name: 'liste_Review')]
    public function getListContact(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $contactRepository = $entityManager->getRepository(Review::class);
        $contact=$contactRepository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($contact, 'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
             }
         ]);
        return new jsonResponse($jsonContent);
    }

    #[Route('/api/activateReview/{token}/{id}/{state}', name: 'app_review_activation')]
    public function Activateticket(EntityManagerInterface $entityManager,string $token,int $id,int $state){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $review=$entityManager->getRepository(Review::class)->find($id);
    if (!$review) {
        throw $this->createNotFoundException(
            'No review found for id '.$id
        );
    }

    $review->setIsActivated($state);
    $entityManager->persist($review);
    $entityManager->flush();
    return new Response("Review activer avec succes");

    }

}
