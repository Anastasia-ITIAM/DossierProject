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

        // Vérifier crédits
        if ($user->getCredits() < 2) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Vous n’avez pas assez de crédits pour publier ce trajet.'
            ], 400);
        }

        // Récupérer l'objet Car depuis la BDD
        $car = $this->em->getRepository(Car::class)->find((int)$data['car_id']);
        if (!$car) {
            return new JsonResponse(['success' => false, 'message' => 'Voiture introuvable'], 404);
        }

        try {
            $trip = new Trip();
            $trip->setDriver($user) // ou $trip->setUser($user) si tu as ajouté l’alias
                 ->setCar($car)
                 ->setDepartureAddress($data['departure_address'] ?? '')
                 ->setArrivalAddress($data['arrival_address'] ?? '')
                 ->setDepartureDate(new \DateTime($data['departure_date'] ?? 'now'))
                 ->setDepartureTime(new \DateTime($data['departure_time'] ?? '00:00'))
                 ->setArrivalTime(new \DateTime($data['arrival_time'] ?? '00:00'))
                 ->setAvailableSeats((int)($data['available_seats'] ?? 0))
                 ->setPrice((int)($data['price'] ?? 0))
                 ->setEcoFriendly((bool)($data['eco_friendly'] ?? false))
                 ->setStatus($data['status'] ?? 'open')
                 ->setFinished(false)
                 ->setParticipantValidation(false);

            $this->em->persist($trip);

            // Déduire 2 crédits pour publier
            $user->setCredits($user->getCredits() - 2);
            $this->em->persist($user);

            $this->em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Trajet publié avec succès',
                'trip_id' => $trip->getId(),
                'credits' => $user->getCredits()
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

        if ($trip->getDriver()->getId() !== $user->getId()) { // ou getUser() si alias
            return new JsonResponse(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        try {
            $this->em->remove($trip);

            // Rembourser 2 crédits
            $user->setCredits($user->getCredits() + 2);
            $this->em->persist($user);

            $this->em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Trajet supprimé avec succès. Vos crédits ont été remboursés.',
                'credits' => $user->getCredits()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ], 500);
        }
    }
}
