<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pseudo = $data['pseudo'] ?? null;
        $password = $data['password'] ?? null;

        if (!$pseudo || !$password) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Pseudo et mot de passe requis'
            ], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        if (!password_verify($password, $user->getPassword())) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Mot de passe incorrect'
            ], 401);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user->getId(),
                'pseudo' => $user->getPseudo(),
                'email' => $user->getEmail(),
                'role' => $user->getRole(),
            ]
        ]);
    }
}
