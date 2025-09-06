<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/car')]
class CarController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // AJOUTER UNE VOITURE
    #[Route('', name: 'add_car', methods: ['POST'])]
    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();

            // Vérification : l’utilisateur doit être connecté
            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Utilisateur non connecté.'
                ], 401);
            }
            // Si l’utilisateur existe, on peut changer son rôle
            $user->setRole('ROLE_PASSENGER_DRIVER');

            // On récupère les données envoyées par le front en JSON
            $data = json_decode($request->getContent(), true);

            // Création d’une nouvelle entité Car
            $car = new Car();
            $car->setLicensePlate($data['license_plate'] ?? '');

            // Sécurité : si la date n’est pas envoyée, on met la date actuelle
            if (!empty($data['registration_date'])) {
                $car->setRegistrationDate(new \DateTime($data['registration_date']));
            } else {
                $car->setRegistrationDate(new \DateTime());
            }

            // Remplissage des autres champs
            $car->setModel($data['model'] ?? '');
            $car->setBrand($data['brand'] ?? '');
            $car->setColor($data['color'] ?? '');
            $car->setFuelType($data['fuel_type'] ?? '');
            $car->setAvailableSeats((int)($data['available_seats'] ?? 0));

            // Champs supplémentaires (à ajouter dans l’entité Car)
            $car->setSmoker((bool)($data['smoker'] ?? false));
            $car->setPetsAllowed((bool)($data['pets_allowed'] ?? false));
            $car->setCustomPreferences($data['custom_preferences'] ?? null);

            // Association : la voiture appartient à l’utilisateur connecté
            $car->setUser($user);

            // Validation de l’entité avant enregistrement
            $errors = $validator->validate($car);
            if (count($errors) > 0) {
                return new JsonResponse([
                    'success' => false,
                    'message' => (string) $errors
                ], 400);
            }

            // Enregistrement dans la base de données
            $this->em->persist($car);
            $this->em->flush();

            // Réponse JSON avec les infos de la voiture enregistrée
            return new JsonResponse([
                'success' => true,
                'message' => 'La voiture a été ajoutée avec succès.',
                'car' => [
                    'id' => $car->getId(),
                    'license_plate' => $car->getLicensePlate(),
                    'brand' => $car->getBrand(),
                    'model' => $car->getModel(),
                    'color' => $car->getColor(),
                    'fuel_type' => $car->getFuelType(),
                    'available_seats' => $car->getAvailableSeats(),
                    'smoker' => $car->isSmoker(),
                    'pets_allowed' => $car->isPetsAllowed(),
                    'custom_preferences' => $car->getCustomPreferences(),
                ],
                'user_id' => $user->getId(),
            ], 201);

        } catch (\Exception $e) {
            // Gestion des erreurs serveur
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ], 500);
        }
    }
}
