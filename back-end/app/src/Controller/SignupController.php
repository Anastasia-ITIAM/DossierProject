<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignupController
{
    #[Route('/api/signup', name: 'api_signup', methods: ['POST'])]
    public function signup(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Vérifier que tous les champs sont présents
        $requiredFields = ['email', 'pseudo', 'motdepasse'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return new JsonResponse(['error' => "$field manquant"], 400);
            }
        }

        // Vérifier si l'email ou le pseudo existe déjà
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Email déjà utilisé'], 400);
        }

        $existingPseudo = $em->getRepository(User::class)->findOneBy(['username' => $data['pseudo']]);
        if ($existingPseudo) {
            return new JsonResponse(['error' => 'Pseudo déjà utilisé'], 400);
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['pseudo']);
        $user->setPasswordHash($passwordHasher->hashPassword($user, $data['motdepasse']));
        $user->setCreatedAt(new \DateTime());
        $user->setRole('ROLE_USER');
        $user->setCreadits(0);
        $user->setStatus('actif');


        $em->persist($user);
        $em->flush();

        return new JsonResponse(['success' => true, 'message' => 'Utilisateur créé']);
    }
}
