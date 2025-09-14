<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/trip/reservation')]
class TripReservationController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // --------------------
    // Réserver un trajet
    // --------------------
    #[Route('/{tripId}', name: 'reserve_trip', methods: ['POST'])]
    public function reserve(int $tripId): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $trip = $this->em->getRepository(Trip::class)->find($tripId);
        if (!$trip) {
            return new JsonResponse(['success' => false, 'message' => 'Trajet introuvable.'], 404);
        }

        if ($trip->getUser()->getId() === $user->getId()) {
            return new JsonResponse(['success' => false, 'message' => 'Vous êtes le conducteur de ce trajet.'], 403);
        }

        if ($trip->getAvailableSeats() <= 0) {
            return new JsonResponse(['success' => false, 'message' => 'Aucune place disponible.'], 400);
        }

        if ($trip->getPassengers()->contains($user)) {
            return new JsonResponse(['success' => false, 'message' => 'Vous avez déjà réservé ce trajet.'], 400);
        }

        // Vérifier si l'utilisateur a assez de crédits
        $tripPrice = $trip->getPrice();
        if ($user->getCredits() < $tripPrice) {
            return new JsonResponse(['success' => false, 'message' => 'Crédits insuffisants.'], 400);
        }

        // Déduire le montant du trajet
        $user->setCredits($user->getCredits() - $tripPrice);

        // Ajouter le passager et mettre à jour les places disponibles
        $trip->addPassenger($user);
        $trip->setAvailableSeats($trip->getAvailableSeats() - 1);

        try {
            $this->em->persist($user); // mettre à jour les crédits
            $this->em->persist($trip);
            $this->em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Trajet réservé avec succès.',
                'trip_id' => $trip->getId(),
                'remaining_credits' => $user->getCredits(),
                'userName' => method_exists($user, 'getPseudo') ? $user->getPseudo() : $user->getUsername(),
                'userEmail' => method_exists($user, 'getEmail') ? $user->getEmail() : '',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur serveur lors de la réservation : ' . $e->getMessage()
            ], 500);
        }
    }

    // --------------------
    // Annuler une réservation
    // --------------------
    #[Route('/cancel/{tripId}', name: 'cancel_reservation', methods: ['POST'])]
    public function cancel(int $tripId): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $trip = $this->em->getRepository(Trip::class)->find($tripId);
        if (!$trip) {
            return new JsonResponse(['success' => false, 'message' => 'Trajet introuvable.'], 404);
        }

        if (!$trip->getPassengers()->contains($user)) {
            return new JsonResponse(['success' => false, 'message' => 'Vous n\'êtes pas inscrit à ce trajet.'], 400);
        }

        // Restituer les crédits au passager
        $tripPrice = $trip->getPrice();
        $user->setCredits($user->getCredits() + $tripPrice);

        // Retirer le passager et mettre à jour les places disponibles
        $trip->removePassenger($user);
        $trip->setAvailableSeats($trip->getAvailableSeats() + 1);

        try {
            $this->em->persist($user); // mettre à jour crédits
            $this->em->persist($trip);
            $this->em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Réservation annulée avec succès.',
                'trip_id' => $trip->getId(),
                'remaining_credits' => $user->getCredits(), // renvoyer le nouveau solde pour le frontend
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur serveur lors de l\'annulation : ' . $e->getMessage()
            ], 500);
        }
    }

    // --------------------
    // Lister les trajets réservés ou publiés par l'utilisateur
    // --------------------
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Utilisateur non connecté.'
            ], 401);
        }

        $trips = $this->em->getRepository(Trip::class)
            ->createQueryBuilder('t')
            ->leftJoin('t.passengers', 'p')
            ->andWhere('p.id = :userId OR t.user = :user')
            ->setParameter('userId', $user->getId())
            ->setParameter('user', $user)
            ->orderBy('t.departure_date', 'ASC')
            ->addOrderBy('t.departure_time', 'ASC')
            ->getQuery()
            ->getResult();

        $tripData = array_map(function(Trip $trip) {
            return [
                'id' => $trip->getId(),
                'user_id' => $trip->getUser()?->getId(),
                'departure_address' => $trip->getDepartureAddress(),
                'arrival_address' => $trip->getArrivalAddress(),
                'departure_date' => $trip->getDepartureDate()?->format('Y-m-d'),
                'departure_time' => $trip->getDepartureTime()?->format('H:i'),
                'arrival_time' => $trip->getArrivalTime()?->format('H:i'),
                'available_seats' => $trip->getAvailableSeats(),
                'price' => $trip->getPrice(),
                'eco_friendly' => $trip->isEcoFriendly(),
            ];
        }, $trips);

        return new JsonResponse([
            'success' => true,
            'trips' => $tripData
        ]);
    }
}
