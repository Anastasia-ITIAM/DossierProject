<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification des champs requis
        if (empty($data['email']) || empty($data['username']) || empty($data['password']) || empty($data['password_confirmation'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        if ($data['password'] !== $data['password_confirmation']) {
            return $this->json(['error' => 'Passwords do not match'], 400);
        }

        // Vérifier si l'email ou le username existe déjà
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->json(['error' => 'Email already registered'], 400);
        }

        $existingUser = $em->getRepository(User::class)->findOneBy(['username' => $data['username']]);
        if ($existingUser) {
            return $this->json(['error' => 'Username already taken'], 400);
        }

        // Création du User
        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setRole('passenger'); // rôle par défaut
        $user->setStatus('active');  // statut par défaut

        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPasswordHash($hashedPassword);

        // Validation
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        // Enregistrement en base
        $em->persist($user);
        $em->flush();

        // Réponse JSON sécurisée
        $response = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'credits' => $user->getCredits(),
            'role' => $user->getRole(),
            'status' => $user->getStatus(),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        return $this->json($response, 201);
    }
}
