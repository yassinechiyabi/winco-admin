<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TicketClient;
use App\Entity\client;
use App\Entity\TicketReplay;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TicketClientController extends AbstractController
{
    
    #[Route('/api/TicketList/{token}', name: 'app_ticket_client')]
    public function getTicketList(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $repository = $entityManager->getRepository(TicketClient::class);
        $tickets = $repository->getAllTickets();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($tickets, 'json');
        return new jsonResponse($jsonContent);

    }
    #[Route('/api/ticketDetails/{token}/{id}', name: 'app_ticket_details')]
    public function getTicketBody(EntityManagerInterface $entityManager,int $id,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $ticket = $entityManager->getRepository(TicketClient::class)->find($id);
        if (!$ticket) {
            throw $this->createNotFoundException(
                'No ticket found for id '.$id
            );
        }
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($ticket,'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
             }
         ]);
        return new jsonResponse($jsonContent);

    }
    #[Route('/api/submitTicketReply/{token}', name: 'app_ticket_reply')]
    public function submitReply(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        $client=$entityManager->getRepository(client::class)->find($request->request->get('id_client'));
        $ticket = $entityManager->getRepository(TicketClient::class)->find($request->request->get('id'));
        if (!$ticket) {
            throw $this->createNotFoundException(
                'No ticket found for id '.$id
            );
        }
        if (!$client) {
            throw $this->createNotFoundException(
                'No client found for id '.$id
            );
        }
        $reply=new TicketReplay();
        $reply->setContenu($request->request->get('contenu'));
        $reply->setIdTicket($ticket);
        $reply->setIdClient($client);
        $entityManager->persist($reply);
        $entityManager->flush();
        return new Response('Saved new Reply');

    }

    #[Route('/api/activateTicket/{token}/{id}/{state}', name: 'app_ticket_activation')]
    public function Activateticket(EntityManagerInterface $entityManager,int $id,int $state,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
    $ticket=$entityManager->getRepository(TicketClient::class)->find($id);
    if (!$ticket) {
        throw $this->createNotFoundException(
            'No ticket found for id '.$id
        );
    }

    $ticket->setEtat($state);
    $entityManager->persist($ticket);
    $entityManager->flush();
    return new Response("Ticket activer avec succes");

    }

    #[Route('/api/removeTicket/{token}/{id}/', name: 'app_ticket_remove')]
    public function removeTicket(EntityManagerInterface $entityManager,int $id,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $ticket=$entityManager->getRepository(TicketClient::class)->find($id);
        if (!$ticket) {
            throw $this->createNotFoundException(
                'No ticket found for id '.$id
            );
        }
        $entityManager->remove($ticket);
        $entityManager->flush();
        return new Response('Ticket supprimer avec success');
    }


}
