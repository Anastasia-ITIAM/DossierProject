<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 *
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    public function add(Trip $trip, bool $flush = true): void
    {
        $this->_em->persist($trip);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Trip $trip, bool $flush = true): void
    {
        $this->_em->remove($trip);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Exemple de méthode personnalisée pour récupérer les trajets d'un utilisateur
     */
    public function findByUserId(int $userId): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user_id = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('t.departure_date', 'ASC')
            ->addOrderBy('t.departure_time', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findUpcomingTrips(int $userId): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('t')
            ->andWhere('t.user_id = :userId')
            ->andWhere('t.departure_date > :now OR (t.departure_date = :now AND t.departure_time > :now)')
            ->setParameter('userId', $userId)
            ->setParameter('now', $now)
            ->orderBy('t.departure_date', 'ASC')
            ->addOrderBy('t.departure_time', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
