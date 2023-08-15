<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Newslettre;
use App\Entity\WincoCanadaSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NewslettreController extends AbstractController
{
    

    #[Route('api/getAllSubs/{token}', name: 'all_subs_media')]
    public function getAllSubs(EntityManagerInterface $entityManager,string $token)
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $repository = $entityManager->getRepository(Newslettre::class);
        $subs = $repository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($subs, 'json');
        return new jsonResponse($jsonContent);
    }

    #[Route('api/activateSub/{token}/{activation}/{id}', name: 'atcivate_subs')]
    public function activator(EntityManagerInterface $entityManager,string $token, int $id,int $activation): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $sub = $entityManager->getRepository(Newslettre::class)->find($id);
        if (!$sub) {
            throw $this->createNotFoundException(
                'No subs found for id '.$id
            );
        }
        $sub->setStatus($activation);
        $entityManager->persist($sub);
        $entityManager->flush();
        return new Response('Abonner activé avec success');
    }

    #[Route('api/removeSub/{token}/{id}', name: 'remove_subs')]
    public function removeSub(EntityManagerInterface $entityManager,string $token, int $id): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $sub = $entityManager->getRepository(Newslettre::class)->find($id);
        if (!$sub) {
            throw $this->createNotFoundException(
                'No subs found for id '.$id
            );
        }
        
        $entityManager->remove($sub);
        $entityManager->flush();
        return new Response('Abonner supprimé avec success');
    }


    // Winco Canada subscriber treatement

    #[Route('api/getAllSubsCanada/{token}', name: 'all_subs_canada')]
    public function getAllSubsCanada(EntityManagerInterface $entityManager,string $token)
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $repository = $entityManager->getRepository(WincoCanadaSubscriber::class);
        $subs = $repository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($subs, 'json');
        return new jsonResponse($jsonContent);
    }

    #[Route('api/activateSubCanada/{token}/{activation}/{id}', name: 'atcivate_canada_subs')]
    public function activatorCanada(EntityManagerInterface $entityManager,string $token, int $id,int $activation): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $sub = $entityManager->getRepository(WincoCanadaSubscriber::class)->find($id);
        if (!$sub) {
            throw $this->createNotFoundException(
                'No subs found for id '.$id
            );
        }
        $sub->setStatus($activation);
        $entityManager->persist($sub);
        $entityManager->flush();
        return new Response('Abonner activé avec success');
    }

    #[Route('api/removeSubCanada/{token}/{id}', name: 'remove_canada_subs')]
    public function removeSubCanada(EntityManagerInterface $entityManager,string $token, int $id): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $sub = $entityManager->getRepository(WincoCanadaSubscriber::class)->find($id);
        if (!$sub) {
            throw $this->createNotFoundException(
                'No subs found for id '.$id
            );
        }
        
        $entityManager->remove($sub);
        $entityManager->flush();
        return new Response('Abonner supprimé avec success');
    }
       
}
