<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\plan;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PlanController extends AbstractController
{
    

    #[Route('api/getAllPlans/{token}', name: 'liste_plan')]
    public function getListPlans(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $plansRepository = $entityManager->getRepository(plan::class);
        $plans=$plansRepository->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($plans, 'json',[ObjectNormalizer::IGNORED_ATTRIBUTES => ['yes','plan','siteClients','ticketClients']]);
        return new jsonResponse($jsonContent);
    }

    #[Route('api/submitNewPlan/{token}', name: 'new_plan')]
    public function store(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        
        $plan = new plan();
        $plan->setNomPlan($request->request->get('nom_plan'));
        $plan->setDescPlan($request->request->get('desc_plan'));
        $plan->setNbrModification($request->request->get('nbr_modification'));
        $plan->setNbrPage($request->request->get('nbr_page'));
        $plan->setNbrPost($request->request->get('nbr_post'));
        $plan->setPrixMensuelPlan($request->request->get('prix_mensuel_plan'));
        $plan->setPrixMiseEnLignePlan($request->request->get('prix_mise_enligne_plan'));
        $plan->setIsActive(0);
        $entityManager->persist($plan);
        $entityManager->flush();
        return new Response('Saved new Plan with id '.$request->request->get('nom_plan'));
    }


    #[Route('api/activatePlan/{token}/{activation}/{id}', name: 'ativate_plan')]
    public function activator(EntityManagerInterface $entityManager,string $token, int $id,int $activation): Response
    {
        

        $plan = $entityManager->getRepository(plan::class)->find($id);

        if (!$plan) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
       
        $plan->setIsActive($activation);
        $entityManager->persist($plan);
        $entityManager->flush();
        return new Response('Plan activé avec success');
        
    }

    
    

    #[Route('api/getSpecificPlan/{token}/{id}', name: 'selectSpecific_plan')]
    public function getSpecificPlan(EntityManagerInterface $entityManager,int $id,string $token): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $plan = $entityManager->getRepository(plan::class)->find($id);
        if (!$plan) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($plan, 'json',[ObjectNormalizer::IGNORED_ATTRIBUTES => ['yes','plan','siteClients','ticketClients']]);
        return new jsonResponse($jsonContent);
        
    }


    #[Route('api/updatePlan/{token}', name: 'update_plan')]
    public function update(EntityManagerInterface $entityManager,string $token): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        $plan = $entityManager->getRepository(plan::class)->find($request->request->get('id_plan'));
        if (!$plan) {
            throw $this->createNotFoundException(
                'No plan found for id '.$id
            );
        }
        $plan->setNomPlan($request->request->get('nom_plan'));
        $plan->setDescPlan($request->request->get('desc_plan'));
        $plan->setNbrModification($request->request->get('nbr_modification'));
        $plan->setNbrPage($request->request->get('nbr_page'));
        $plan->setNbrPost($request->request->get('nbr_post'));
        $plan->setPrixMensuelPlan($request->request->get('prix_mensuel_plan'));
        $plan->setPrixMiseEnLignePlan($request->request->get('prix_mise_enligne_plan'));
        $entityManager->persist($plan);
        $entityManager->flush();
        return new Response('Mise à jour du plan avec success');
        
    }

    #[Route('api/removePlan/{token}/{id}', name: 'remove_plan')]
    public function remove(EntityManagerInterface $entityManager, int $id,string $token): Response
    {
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        $plan = $entityManager->getRepository(plan::class)->find($id);
        if (!$plan) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $entityManager->remove($plan);
        $entityManager->flush();
        return new Response('Plan supprimer avec success');
        
    }


}
