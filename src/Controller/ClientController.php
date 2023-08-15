<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class ClientController extends AbstractController
{
    #[Route('api/updateClient/{token}', name: 'create_client')]
    public function update(EntityManagerInterface $entityManager,string $token): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $request = Request::createFromGlobals();
        $client = $entityManager->getRepository(client::class)->find($request->request->get('id'));
        if (!$client) {
            throw $this->createNotFoundException(
                'No client found for id '.$id
            );
        }
        $client->setNomClient($request->request->get('nomClient'));
        $client->setPrenomClient($request->request->get('prenomClient'));
        $client->setEmail($request->request->get('email'));
        $client->setPhone($request->request->get('phone'));
        $entityManager->persist($client);
        $entityManager->flush();

        return new Response('Client updated '.$client->getId());
    }


    #[Route('api/removeClient/{token}/{id}', name: 'remove_client')]
    public function remove(EntityManagerInterface $entityManager, int $id,string $token): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        $client = $entityManager->getRepository(client::class)->find($id);
        if (!$client) {
            throw $this->createNotFoundException(
                'No client found for id '.$id
            );
        }
        $entityManager->remove($client);
        $entityManager->flush();
        return new Response('Client supprimer avec success');
        
    }



    #[Route('api/ListClients/{token}', name: 'liste_client')]
    public function getListClients(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $clientsRepository = $entityManager->getRepository(client::class);
        $clients=$clientsRepository->ClientTableList();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($clients, 'json',[ObjectNormalizer::IGNORED_ATTRIBUTES => ['commandes','password','siteClients','ticketClients']]);
        return new jsonResponse($jsonContent);
    }

    #[Route('api/getSpecificClient/{token}/{id}', name: 'selectSpecific_client')]
    public function getSpecificClient(EntityManagerInterface $entityManager,string $token,int $id): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $client = $entityManager->getRepository(client::class)->find($id);
        if (!$client) {
            throw $this->createNotFoundException(
                'No client found for id '.$id
            );
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($client, 'json',[ObjectNormalizer::IGNORED_ATTRIBUTES => ['commandes','password','siteClients','ticketClients','reviews']]);
        return new jsonResponse($jsonContent);
        
    }

}
