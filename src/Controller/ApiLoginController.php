<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\ApiToken;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Doctrine\ORM\EntityManagerInterface;


class ApiLoginController extends AbstractController
{
    #[Route('api/login', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user,EntityManagerInterface $emi): Response
      {


         if (null === $user) {
             return $this->json([
                 'message' => 'missing credentials',
             ], Response::HTTP_UNAUTHORIZED);
         }

         $repository = $emi->getRepository(ApiToken::class);
         $checking = $repository->desctivateAllTokens($user->getId());

         $token=uniqid(rand());
         $api=new ApiToken();
         $api->setToken($token);
         $api->setIdUser($user);
         $api->setIsActive(1);
         $emi->persist($api);
         $emi->flush();



          return $this->json([
             'message' => 'Welcome to your new controller!',
             'path' => 'src/Controller/ApiLoginController.php',
             'user'  => $user->getUserIdentifier(),
             'token'=> $api->getToken(),
          ]);
      }

      #[Route('api/checkToken/{token}', name: 'api_check_token')]
    public function checkToken(EntityManagerInterface $emi,string $token): Response
    {
        $repository = $emi->getRepository(ApiToken::class);
        $checking = $repository->findToken($token);
        if($checking[0]['compteur']<1){
            return new Response('Token Erroner',Response::HTTP_UNAUTHORIZED);
        }
        else{
            return new Response('Token valider');
        }



    }

    #[Route('api/logout/{token}', name: 'api_logout')]
    public function logout(EntityManagerInterface $emi,string $token): Response
      {
         
         $repository = $emi->getRepository(ApiToken::class);
         $checking = $repository->flagToken($token);
         return new Response("Deconnexion réussi");
    }

    public static function checkTokenStatic(EntityManagerInterface $emi,string $token)
    {
        
        $repository = $emi->getRepository(ApiToken::class);
        $checking = $repository->findToken($token);
        if($checking[0]['compteur']<1){
            return false;
        }
        else{
            return true;
        }

    }
}
