<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
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

        try {
            $trip = new Trip();
            $trip->setUser($user)
                ->setCarId((int)$data['car_id'])
                ->setDepartureAddress($data['departure_address'] ?? '')
                ->setArrivalAddress($data['arrival_address'] ?? '')
                ->setDepartureDate(new \DateTime($data['departure_date'] ?? 'now'))
                ->setDepartureTime(new \DateTime($data['departure_time'] ?? 'now'))
                ->setArrivalTime(new \DateTime($data['arrival_time'] ?? 'now'))
                ->setAvailableSeats((int)($data['available_seats'] ?? 0))
                ->setPrice((int)($data['price'] ?? 0))
                ->setEcoFriendly((bool)($data['eco_friendly'] ?? false))
                ->setStatus($data['status'] ?? 'open')
                ->setFinished(false)
                ->setParticipantValidation(false);

            $this->em->persist($trip);
            $this->em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Trajet publié avec succès',
                'trip_id' => $trip->getId()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur lors de la création du trajet : ' . $e->getMessage()
            ], 500);
        }
    }

    // --------------------
    // Supprimer un trajet
    // --------------------
    #[Route('/delete/{id}', name: 'delete_trip', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $trip = $this->em->getRepository(Trip::class)->find($id);
        if (!$trip) {
            return new JsonResponse(['success' => false, 'message' => 'Trajet introuvable.'], 404);
        }

        if ($trip->getUser()->getId() !== $user->getId()) {
            return new JsonResponse(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        try {
            $this->em->remove($trip);
            $this->em->flush();

            return new JsonResponse(['success' => true, 'message' => 'Trajet supprimé avec succès.']);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ], 500);
        }
    }
}
