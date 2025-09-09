<?php

namespace App\Controller;

use App\Entity\Trip;
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
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['car_id'])) {
            return new JsonResponse(['success' => false, 'message' => 'Car ID requis'], 400);
        }

        $trip = new Trip();
        $trip->setUserId($user->getId());
        $trip->setCarId((int)$data['car_id']);
        $trip->setDepartureAddress($data['departure_address'] ?? '');
        $trip->setArrivalAddress($data['arrival_address'] ?? '');
        $trip->setDepartureDate(new \DateTime($data['departure_date'] ?? 'now'));
        $trip->setDepartureTime(new \DateTime($data['departure_time'] ?? 'now'));
        $trip->setArrivalTime(new \DateTime($data['arrival_time'] ?? 'now'));
        $trip->setAvailableSeats((int)($data['available_seats'] ?? 0));
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
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $trips = $this->em->getRepository(Trip::class)->findBy(
            ['user_id' => $user->getId()],
            ['departure_date' => 'ASC', 'departure_time' => 'ASC']
        );

        $result = array_map(function (Trip $trip) {
            return [
                'id' => $trip->getId(),
                'car_id' => $trip->getCarId(),
                'departure_address' => $trip->getDepartureAddress(),
                'arrival_address' => $trip->getArrivalAddress(),
                'departure_date' => $trip->getDepartureDate()->format('Y-m-d'),
                'departure_time' => $trip->getDepartureTime()->format('H:i'),
                'arrival_time' => $trip->getArrivalTime()->format('H:i'),
                'available_seats' => $trip->getAvailableSeats(),
                'eco_friendly' => $trip->isEcoFriendly(),
                'status' => $trip->getStatus(),
                'finished' => $trip->isFinished(),
                'participant_validation' => $trip->isParticipantValidation(),
            ];
        }, $trips);

        return new JsonResponse(['success' => true, 'trips' => $result]);
    }

    // --------------------
    // Supprimer un trajet
    // --------------------
    #[Route('/delete/{id}', name: 'delete_trip', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $trip = $this->em->getRepository(Trip::class)->find($id);

        if (!$trip || $trip->getUserId() !== $user->getId()) {
            return new JsonResponse(['success' => false, 'message' => 'Trajet introuvable ou accès refusé.'], 404);
        }

        $this->em->remove($trip);
        $this->em->flush();

        return new JsonResponse(['success' => true, 'message' => 'Trajet supprimé avec succès.']);
    }
}
