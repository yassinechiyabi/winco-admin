<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class GenerateUserController extends AbstractController
{
    #[Route('/generate/user', name: 'app_generate_user')]
    public function index(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $request = Request::createFromGlobals();

        // ... e.g. get the user data from a registration form
        $user = new User();
        $plaintextPassword = "winco2023";
        
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail('d.akalai@gmail.com');
        $entityManager->persist($user);
        $entityManager->flush();
        
        // ...
    }
}
