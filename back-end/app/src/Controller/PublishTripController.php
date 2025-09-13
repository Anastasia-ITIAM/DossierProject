<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/trip')]
class PublishTripController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // --------------------
    // Ajouter un trajet
    // --------------------
    #[Route('/add', name: 'publish_trip', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['car_id'])) {
            return new JsonResponse(['success' => false, 'message' => 'Car ID requis'], 400);
        }

        $trip = new Trip();
        $trip->setUser($user);
        $trip->setCarId((int)$data['car_id']);
        $trip->setDepartureAddress($data['departure_address'] ?? '');
        $trip->setArrivalAddress($data['arrival_address'] ?? '');
        $trip->setDepartureDate(new \DateTime($data['departure_date'] ?? 'now'));
        $trip->setDepartureTime(new \DateTime($data['departure_time'] ?? 'now'));
        $trip->setArrivalTime(new \DateTime($data['arrival_time'] ?? 'now'));
        $trip->setAvailableSeats((int)($data['available_seats'] ?? 0));
        $trip->setPrice((int)($data['price'] ?? 0));
        $trip->setEcoFriendly((bool)($data['eco_friendly'] ?? false));
        $trip->setStatus($data['status'] ?? 'published');
        $trip->setFinished(false);
        $trip->setParticipantValidation(false);

        $this->em->persist($trip);
        $this->em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Trajet publié avec succès',
            'trip_id' => $trip->getId()
        ]);
    }

    // --------------------
    // Lister les trajets de l'utilisateur
    // --------------------
    #[Route('/list', name: 'list_trips', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $trips = $this->em->getRepository(Trip::class)
            ->findBy(['user' => $user], ['departure_date' => 'ASC', 'departure_time' => 'ASC']);

        $data = array_map(function(Trip $trip) {
            return [
                'id' => $trip->getId(),
                'car_id' => $trip->getCarId(),
                'user_id' => $trip->getUser()?->getId(),
                'departure_address' => $trip->getDepartureAddress(),
                'arrival_address' => $trip->getArrivalAddress(),
                'departure_date' => $trip->getDepartureDate()?->format('Y-m-d'),
                'departure_time' => $trip->getDepartureTime()?->format('H:i'),
                'arrival_time' => $trip->getArrivalTime()?->format('H:i'),
                'available_seats' => $trip->getAvailableSeats(),
                'price' => $trip->getPrice(),
                'eco_friendly' => $trip->isEcoFriendly(),
                'status' => $trip->getStatus(),
                'finished' => $trip->isFinished(),
                'participant_validation' => $trip->isParticipantValidation(),
            ];
        }, $trips);

        return new JsonResponse(['success' => true, 'trips' => $data]);
    }

    // --------------------
    // Détails d'un trajet par ID
    // --------------------
    #[Route('/{id}', name: 'trip_details', methods: ['GET'])]
    public function details(int $id): JsonResponse
    {
        $trip = $this->em->getRepository(Trip::class)->find($id);

        if (!$trip) {
            return new JsonResponse(['success' => false, 'message' => 'Trajet non trouvé'], 404);
        }

        $driver = $trip->getUser();
        $driverName = $driver ? $driver->getPseudo() : 'Inconnu';

        // Récupérer le véhicule lié au car_id
        $car = $this->em->getRepository(Car::class)->find($trip->getCarId());
        $vehicle = $car ? sprintf('%s %s (%s)', $car->getBrand(), $car->getModel(), $car->getColor()) : null;

        return new JsonResponse([
            'success' => true,
            'trip' => [
                'id' => $trip->getId(),
                'car_id' => $trip->getCarId(),
                'user_id' => $driver?->getId(),
                'departure_address' => $trip->getDepartureAddress(),
                'arrival_address' => $trip->getArrivalAddress(),
                'departure_date' => $trip->getDepartureDate()?->format('Y-m-d'),
                'departure_time' => $trip->getDepartureTime()?->format('H:i'),
                'arrival_time' => $trip->getArrivalTime()?->format('H:i'),
                'available_seats' => $trip->getAvailableSeats(),
                'price' => $trip->getPrice(),
                'eco_friendly' => $trip->isEcoFriendly(),
                'status' => $trip->getStatus(),
                'finished' => $trip->isFinished(),
                'participant_validation' => $trip->isParticipantValidation(),
                'driver_name' => $driverName,
                'vehicle' => $vehicle,
                'passengers' => [] // à compléter plus tard
            ]
        ]);
    }
}
