<?php

namespace App\Controller;

use App\Document\TripReview;
use App\Entity\Trip;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/trip', name: 'trip_review_')]
class TripReviewController extends AbstractController
{
    private DocumentManager $dm;
    private EntityManagerInterface $em;

    public function __construct(DocumentManager $dm, EntityManagerInterface $em)
    {
        $this->dm = $dm;
        $this->em = $em;
    }

    // --- Ajouter un avis ---
    #[Route('/{tripId}/reviews', name: 'add', methods: ['POST'])]
    public function add(int $tripId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || empty($data['userId']) || empty($data['comment']) || !isset($data['rating'])) {
            return $this->json([
                'success' => false,
                'message' => 'Données invalides.'
            ], 400);
        }

        // Vérifie que le trajet existe en MySQL
        $trip = $this->em->getRepository(Trip::class)->find($tripId);
        if (!$trip) {
            return $this->json(['success' => false, 'message' => 'Trajet introuvable'], 404);
        }

        // Vérifie que l’utilisateur existe en MySQL
        $user = $this->em->getRepository(User::class)->find($data['userId']);
        if (!$user) {
            return $this->json(['success' => false, 'message' => 'Utilisateur introuvable'], 404);
        }

        $review = new TripReview();
        $review->setTripId((string) $trip->getId());
        $review->setUserId((string) $user->getId());
        $review->setComment($data['comment']);
        $review->setRating((int) $data['rating']);
        $review->setCreatedAt(new \DateTime());

        $this->dm->persist($review);
        $this->dm->flush();

        return $this->json([
            'success' => true,
            'review_id' => $review->getId()
        ], 201);
    }

    // --- Lister les avis d’un trajet ---
    #[Route('/{tripId}/reviews', name: 'list', methods: ['GET'])]
    public function getReviews(int $tripId): JsonResponse
    {
        $reviews = $this->dm->getRepository(TripReview::class)
                            ->findBy(['tripId' => (string) $tripId]);

        $data = array_map(fn(TripReview $r) => [
            'id' => $r->getId(),
            'tripId' => $r->getTripId(),
            'userId' => $r->getUserId(),
            'comment' => $r->getComment(),
            'rating' => $r->getRating(),
            'createdAt' => $r->getCreatedAt()->format('Y-m-d H:i')
        ], $reviews);

        return $this->json([
            'success' => true,
            'reviews' => $data
        ]);
    }
}
