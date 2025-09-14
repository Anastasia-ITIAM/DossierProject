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
    // Ajouter un trajet (auth nécessaire)
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
            ->setStatus($data['status'] ?? 'published')
            ->setFinished(false)
            ->setParticipantValidation(false);

        $this->em->persist($trip);
        $this->em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Trajet publié avec succès',
            'trip_id' => $trip->getId()
        ]);
    }

    // --------------------
    // Lister les trajets de l'utilisateur (auth nécessaire)
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

        return new JsonResponse([
            'success' => true,
            'trips' => array_map([$this, 'formatTrip'], $trips)
        ]);
    }

    // --------------------
    // Lister tous les trajets publiés (page recherche initiale)
    // --------------------
    #[Route('/all', name: 'all_trips', methods: ['GET'])]
    public function all(): JsonResponse
    {
        $trips = $this->em->getRepository(Trip::class)
            ->findBy(['status' => 'published'], ['departure_date' => 'ASC', 'departure_time' => 'ASC']);

        return new JsonResponse([
            'success' => true,
            'trips' => array_map([$this, 'formatTrip'], $trips)
        ]);
    }

    // --------------------
    // Recherche trajets (départ, arrivée, date) — publique
    // --------------------
    #[Route('/search', name: 'search_trips', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $depart = $request->query->get('depart');
        $arrivee = $request->query->get('arrivee');
        $datetime = $request->query->get('datetime');

        $qb = $this->em->getRepository(Trip::class)->createQueryBuilder('t');
        $qb->andWhere('t.status = :status')->setParameter('status', 'published');

        if ($depart || $arrivee) {
            $orX = $qb->expr()->orX();
            if ($depart) {
                $orX->add($qb->expr()->like('t.departure_address', ':depart'));
                $qb->setParameter('depart', '%' . $depart . '%');
            }
            if ($arrivee) {
                $orX->add($qb->expr()->like('t.arrival_address', ':arrivee'));
                $qb->setParameter('arrivee', '%' . $arrivee . '%');
            }
            $qb->andWhere($orX);
        }

        if ($datetime) {
            try {
                $dt = new \DateTime($datetime);
                $qb->andWhere('t.departure_date >= :date')->setParameter('date', $dt);
            } catch (\Exception $e) {
                return new JsonResponse(['success' => false, 'message' => 'Date invalide'], 400);
            }
        }

        try {
            $trips = $qb->orderBy('t.departure_date', 'ASC')
                        ->addOrderBy('t.departure_time', 'ASC')
                        ->getQuery()
                        ->getResult();
        } catch (\Exception $e) {
            $this->get('logger')->error('Erreur search trips: '.$e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['success' => false, 'message' => 'Erreur serveur'], 500);
        }

        return new JsonResponse([
            'success' => true,
            'trips' => array_map([$this, 'formatTrip'], $trips)
        ]);
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

        return new JsonResponse([
            'success' => true,
            'trip' => $this->formatTrip($trip, true)
        ]);
    }

    // --------------------
    // Format commun d’un trajet
    // --------------------
    private function formatTrip(Trip $trip, bool $withDetails = false): array
    {
        $driver = $trip->getUser();
        $driverName = $driver ? $driver->getPseudo() : 'Inconnu';

        $car = $this->em->getRepository(Car::class)->find($trip->getCarId());
        $vehicle = $car ? sprintf('%s %s (%s)', $car->getBrand(), $car->getModel(), $car->getColor()) : null;

        $data = [
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
        ];

        if ($withDetails) {
            $data['vehicle'] = $vehicle;
            $data['passengers'] = []; // à compléter plus tard
        }

        return $data;
    }
}
