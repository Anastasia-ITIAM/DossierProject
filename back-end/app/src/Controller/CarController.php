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
    #[Route('/add', name: 'add_car', methods: ['POST'])]
    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();

            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Utilisateur non connecté.'
                ], 401);
            }

            // Changer le rôle de l’utilisateur
            $user->setRole('ROLE_PASSENGER_DRIVER');

            // Récupération des données JSON envoyées par le front
            $data = json_decode($request->getContent(), true);

            $car = new Car();
            $car->setLicensePlate($data['license_plate'] ?? '');
            $car->setRegistrationDate(!empty($data['registration_date']) ? new \DateTime($data['registration_date']) : new \DateTime());
            $car->setModel($data['model'] ?? '');
            $car->setBrand($data['brand'] ?? '');
            $car->setColor($data['color'] ?? '');
            $car->setFuelType($data['fuel_type'] ?? '');
            $car->setAvailableSeats((int)($data['available_seats'] ?? 0));
            $car->setCustomPreferences($data['custom_preferences'] ?? null);
            $car->setUser($user);

            // Validation
            $errors = $validator->validate($car);
            if (count($errors) > 0) {
                return new JsonResponse([
                    'success' => false,
                    'message' => (string) $errors
                ], 400);
            }

            $this->em->persist($car);
            $this->em->flush();

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
                    'custom_preferences' => $car->getCustomPreferences(),
                ],
                'user_id' => $user->getId(),
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ], 500);
        }
    }

    // LISTER LES VOITURES DE L’UTILISATEUR
#[Route('/list', name: 'my_cars', methods: ['GET'])]
public function myCars(): JsonResponse
{
    /** @var \App\Entity\User $user */
    $user = $this->getUser();

    if (!$user) {
        return new JsonResponse([
            'success' => false,
            'message' => 'Utilisateur non connecté.'
        ], 401);
    }

    $cars = $user->getCars()->map(function($car) {
        return [
            'id' => $car->getId(),
            'license_plate' => $car->getLicensePlate(),
            // ✅ Ajout de la date formatée pour l’input type="date"
            'registration_date' => $car->getRegistrationDate()
                ? $car->getRegistrationDate()->format('Y-m-d')
                : null,
            'brand' => $car->getBrand(),
            'model' => $car->getModel(),
            'color' => $car->getColor(),
            // ✅ fuelType exposé correctement
            'fuel_type' => $car->getFuelType(),
            'available_seats' => $car->getAvailableSeats(),
            'custom_preferences' => $car->getCustomPreferences(),
        ];
    })->toArray();

    return new JsonResponse([
        'success' => true,
        'cars' => $cars
    ]);
}
}
