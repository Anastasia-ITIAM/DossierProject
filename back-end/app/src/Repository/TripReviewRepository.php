<?php

namespace App\Repository;

use App\Document\TripReview;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class TripReviewRepository extends DocumentRepository
{
    /**
     * Récupère toutes les reviews d’un trajet donné.
     *
     * @param string $tripId
     * @return TripReview[]
     */
    public function findByTrip(string $tripId): array
    {
        return $this->createQueryBuilder()
            ->field('tripId')->equals($tripId)
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Compte le nombre de reviews pour un trajet donné.
     *
     * @param string $tripId
     * @return int
     */
    public function getReviewCountByTrip(string $tripId): int
    {
        $reviews = $this->findByTrip($tripId);
        return count($reviews);
    }

    /**
     * Calcule la note moyenne d’un trajet.
     *
     * @param string $tripId
     * @return float
     */
    public function getAverageRatingByTrip(string $tripId): float
    {
        $reviews = $this->findByTrip($tripId);

        if (empty($reviews)) {
            return 0.0;
        }

        $sum = 0;
        foreach ($reviews as $review) {
            $sum += $review->getRating();
        }

        return $sum / count($reviews);
    }

    /**
     * Récupère les dernières reviews (limit)
     *
     * @param string $tripId
     * @param int $limit
     * @return TripReview[]
     */
    public function findLatestByTrip(string $tripId, int $limit = 5): array
    {
        return $this->createQueryBuilder()
            ->field('tripId')->equals($tripId)
            ->sort('createdAt', 'DESC')
            ->limit($limit)
            ->getQuery()
            ->execute()
            ->toArray();
    }
}
