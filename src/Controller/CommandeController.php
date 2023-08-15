<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Entity\siteClient;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommandeController extends AbstractController
{

    #[Route('api/CommandesList/{token}', name: 'app_commande')]
    public function getAllCommandes(EntityManagerInterface $entityManager,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $repository = $entityManager->getRepository(Commande::class);
        $commandes = $repository->getAllCommandes();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers ,$encoders);
        $jsonContent = $serializer->normalize($commandes, 'json');
        return new jsonResponse($jsonContent);
    }

    #[Route('api/confirmCommande/{token}/{id}', name: 'commande_confirm')]
    public function confirmer(EntityManagerInterface $entityManager,int $id,string $token){
        if (!ApiLoginController::checkTokenStatic($entityManager,$token)) {
            return $this->json([
                'message' => 'Token erroner',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $request = Request::createFromGlobals();
        $commande = $entityManager->getRepository(Commande::class)->find($id);
        if (!$commande) {
            throw $this->createNotFoundException(
                'No commande found for id '.$id
            );
        }
        $commande->setEtat(1);
        $entityManager->persist($commande);
        $entityManager->flush();

        $site=new siteClient();
        $site->setNomSite($commande->getNomSite());
        $site->setDescriptionSite("");
        $site->setDomaineSite($commande->getDomaine());
        $site->setTypeSite($commande->getTypeSite());
        $site->setIdPlan($commande->getIdPlan());
        $site->setIdClient($commande->getIdClient());
        $site->setShowMain(0);
        $site->setImagesUrl("");
        $entityManager->persist($site);
        $entityManager->flush();

        return new Response('Commande confirmer  '.$commande->getId()."Siteweb créer" .$site->getDomaineSite());
    }


}
