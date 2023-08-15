<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\siteClient;
use App\Entity\plan;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SiteClientController extends AbstractController
{
   

    #[Route('api/siteClientList/{token}', name: 'app_sites')]
    public function getAllSites(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $repository = $entityManager->getRepository(siteClient::class);
        $sites = $repository->getSitesList();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($sites, 'json');
        return new jsonResponse($jsonContent);
    }

    #[Route('api/singleSiteClient/{token}/{id}', name: 'single_site')]
    public function getSingleSite(EntityManagerInterface $entityManager,int $id,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $site = $entityManager->getRepository(siteClient::class)->find($id);
        if (!$site) {
            throw $this->createNotFoundException(
                'No website found for id '.$id
            );
        }
        $arraySite[0]=$site;
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($site,'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
             }
         ]);
        return new jsonResponse($jsonContent);
    }
    #[Route('api/updateWebsite/{token}', name: 'update_site')]
    public function updateWebSite(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        $website = $entityManager->getRepository(siteClient::class)->find($request->request->get('id'));
        if (!$website) {
            throw $this->createNotFoundException(
                'No Wbesite found found for id '.$request->request->get('id')
            );
        }
        $plan=$entityManager->getRepository(plan::class)->find($request->request->get('id_plan'));
        if (!$plan) {
            throw $this->createNotFoundException(
                'No Plan for id '.$request->request->get('id_plan'));
            
        }
        $website->setNomSite($request->request->get('nom_site'));
        $website->setDescriptionSite($request->request->get('desc_site'));
        $website->setDomaineSite($request->request->get('domaine_site'));
        $website->setTypeSite($request->request->get('type_site'));
        $website->setIdPlan($plan);
        $website->setImagesUrl($request->request->get('images_url'));
        $entityManager->persist($website);
        $entityManager->flush();
        return new Response('Mise à jour du siteweb avec success');
    }
    #[Route('api/removeWebsite/{token}/{id}', name: 'remove_site')]
    public function removeWebSite(EntityManagerInterface $entityManager,int $id,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $website = $entityManager->getRepository(siteClient::class)->find($id);
        if (!$website) {
            throw $this->createNotFoundException(
                'No Wbesite found found for id '.$id
            );
        }
        $entityManager->remove($website);
        $entityManager->flush();
        return new Response('Website supprimer avec success');
    }

}
