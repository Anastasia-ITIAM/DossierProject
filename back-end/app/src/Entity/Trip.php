<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $car_id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $departure_address = null;

    #[ORM\Column(length: 255)]
    private ?string $arrival_address = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $departure_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $departure_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $arrival_time = null;

    #[ORM\Column]
    private ?int $available_seats = null;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private ?int $price = 0;

    #[ORM\Column]
    private ?bool $eco_friendly = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?bool $finished = null;

    #[ORM\Column(nullable: true)]
    private ?bool $participant_validation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCarId(): ?int
    {
        return $this->car_id;
    }

    public function setCarId(int $car_id): static
    {
        $this->car_id = $car_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDepartureAddress(): ?string
    {
        return $this->departure_address;
    }

    public function setDepartureAddress(string $departure_address): static
    {
        $this->departure_address = $departure_address;

        return $this;
    }

    public function getArrivalAddress(): ?string
    {
        return $this->arrival_address;
    }

    public function setArrivalAddress(string $arrival_address): static
    {
        $this->arrival_address = $arrival_address;

        return $this;
    }

    public function getDepartureDate(): ?\DateTime
    {
        return $this->departure_date;
    }

    public function setDepartureDate(\DateTime $departure_date): static
    {
        $this->departure_date = $departure_date;

        return $this;
    }

    public function getDepartureTime(): ?\DateTime
    {
        return $this->departure_time;
    }

    public function setDepartureTime(\DateTime $departure_time): static
    {
        $this->departure_time = $departure_time;

        return $this;
    }

    public function getArrivalTime(): ?\DateTime
    {
        return $this->arrival_time;
    }

    public function setArrivalTime(\DateTime $arrival_time): static
    {
        $this->arrival_time = $arrival_time;

        return $this;
    }

    public function getAvailableSeats(): ?int
    {
        return $this->available_seats;
    }

    public function setAvailableSeats(int $available_seats): static
    {
        $this->available_seats = $available_seats;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function isEcoFriendly(): ?bool
    {
        return $this->eco_friendly;
    }

    public function setEcoFriendly(bool $eco_friendly): static
    {
        $this->eco_friendly = $eco_friendly;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(?bool $finished): static
    {
        $this->finished = $finished;

        return $this;
    }

    public function isParticipantValidation(): ?bool
    {
        return $this->participant_validation;
    }

    public function setParticipantValidation(?bool $participant_validation): static
    {
        $this->participant_validation = $participant_validation;

        return $this;
    }
}
