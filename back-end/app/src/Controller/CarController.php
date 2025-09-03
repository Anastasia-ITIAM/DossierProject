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
            // -----------------------------
            // FIX #1 : Cast explicite pour Intelephense
            // -----------------------------
            /** @var \App\Entity\User $user */
            $user = $this->getUser();

            // -----------------------------
            // Vérifier que l'utilisateur est connecté
            // -----------------------------
            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Utilisateur non connecté.'
                ], 401);
            }

            $data = json_decode($request->getContent(), true);

            $car = new Car();
            $car->setLicensePlate($data['license_plate'] ?? '');

            // -----------------------------
            // FIX #2 : Gestion sécurisée de la date
            // -----------------------------
            if (!empty($data['registration_date'])) {
                $car->setRegistrationDate(new \DateTime($data['registration_date']));
            } else {
                $car->setRegistrationDate(new \DateTime()); // date actuelle par défaut
            }

            $car->setModel($data['model'] ?? '');
            $car->setBrand($data['brand'] ?? '');
            $car->setColor($data['color'] ?? '');
            $car->setFuelType($data['fuel_type'] ?? '');
            $car->setAvailableSeats((int)($data['available_seats'] ?? 0));

            // -----------------------------
            // Associer la voiture à l’utilisateur connecté
            // -----------------------------
            $car->setUser($user);

            // -----------------------------
            // Validation de l'entité avant persistance
            // -----------------------------
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
                'car_id' => $car->getId(),
                'user_id' => $user->getId(), // Intelephense ne se plaint plus grâce au cast
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ], 500);
        }
    }
}
