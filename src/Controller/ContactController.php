<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use App\Entity\WincoCanadaContact;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ContactController extends AbstractController
{
    #[Route('api/getallContactMedia/{token}', name: 'liste_contact_media')]
    public function getListContact(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $contactRepository = $entityManager->getRepository(Contact::class);
        $contact=$contactRepository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($contact, 'json');
        return new jsonResponse($jsonContent);
    }

    #[Route('api/MarkRead/{token}/{id}/{activation}', name: 'Markread_contact_media')]
    public function MarkReadMedia(EntityManagerInterface $entityManager,string $token,int $id,int $activation){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $message = $entityManager->getRepository(Contact::class)->find($id);
        if (!$message) {
            throw $this->createNotFoundException(
                'No message found for id '.$id
            );
        }

        $message->setLu($activation);
        $entityManager->persist($message);
        $entityManager->flush();
        return new Response('Marquer comme lu');
      
    }

    #[Route('api/getAllContactCanada/{token}', name: 'Contact_winco_canada')]
    public function getAllContactCanada(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $contactRepository = $entityManager->getRepository(WincoCanadaContact::class);
        $contact=$contactRepository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($contact, 'json');
        return new jsonResponse($jsonContent);
      
    }

    #[Route('api/MarkReadCanada/{token}/{id}/{activation}', name: 'Markread_contact_canada')]
    public function MarkReadCanada(EntityManagerInterface $entityManager,string $token,int $id,int $activation){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $message = $entityManager->getRepository(WincoCanadaContact::class)->find($id);
        if (!$message) {
            throw $this->createNotFoundException(
                'No message found for id '.$id
            );
        }

        $message->setLu($activation);
        $entityManager->persist($message);
        $entityManager->flush();
        return new Response('Marquer comme lu');
      
    }

}
