<?php

namespace App\Repository;

use App\Entity\DriverPreference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DriverPreference>
 *
 * @method DriverPreference|null find($id, $lockMode = null, $lockVersion = null)
 * @method DriverPreference|null findOneBy(array $criteria, array $orderBy = null)
 * @method DriverPreference[]    findAll()
 * @method DriverPreference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DriverPreferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DriverPreference::class);
    }

    public function add(DriverPreference $preference, bool $flush = true): void
    {
        $this->_em->persist($preference);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(DriverPreference $preference, bool $flush = true): void
    {
        $this->_em->remove($preference);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByDriverId(int $driverId): ?DriverPreference
    {
        return $this->createQueryBuilder('dp')
            ->andWhere('dp.driver_id = :driverId')
            ->setParameter('driverId', $driverId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}