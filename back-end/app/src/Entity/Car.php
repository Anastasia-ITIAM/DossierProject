<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $license_plate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $registration_date = null;

    #[ORM\Column(length: 50)]
    private ?string $model = null;

    #[ORM\Column(length: 50)]
    private ?string $brand = null;

    #[ORM\Column(length: 30)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $fuel_type = null;

    #[ORM\Column]
    private ?int $available_seats = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // === GETTERS & SETTERS ===

    public function getId(): ?int { return $this->id; }

    public function getLicensePlate(): ?string { return $this->license_plate; }
    public function setLicensePlate(string $license_plate): static { $this->license_plate = $license_plate; return $this; }

    public function getRegistrationDate(): ?\DateTime { return $this->registration_date; }
    public function setRegistrationDate(\DateTime $registration_date): static { $this->registration_date = $registration_date; return $this; }

    public function getModel(): ?string { return $this->model; }
    public function setModel(string $model): static { $this->model = $model; return $this; }

    public function getBrand(): ?string { return $this->brand; }
    public function setBrand(string $brand): static { $this->brand = $brand; return $this; }

    public function getColor(): ?string { return $this->color; }
    public function setColor(string $color): static { $this->color = $color; return $this; }

    public function getFuelType(): ?string { return $this->fuel_type; }
    public function setFuelType(string $fuel_type): static { $this->fuel_type = $fuel_type; return $this; }

    public function getAvailableSeats(): ?int { return $this->available_seats; }
    public function setAvailableSeats(int $available_seats): static { $this->available_seats = $available_seats; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }
}
