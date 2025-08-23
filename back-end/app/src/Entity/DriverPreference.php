<?php

namespace App\Entity;

use App\Repository\DriverPreferenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverPreferenceRepository::class)]
class DriverPreference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $driver_id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $music = null;

    #[ORM\Column(nullable: true)]
    private ?bool $conversation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $pets_allowed = null;

    #[ORM\Column(nullable: true)]
    private ?bool $air_conditioning = null;

    #[ORM\Column(nullable: true)]
    private ?bool $smoker = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $custom_preferences = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDriverId(): ?int
    {
        return $this->driver_id;
    }

    public function setDriverId(int $driver_id): static
    {
        $this->driver_id = $driver_id;

        return $this;
    }

    public function isMusic(): ?bool
    {
        return $this->music;
    }

    public function setMusic(?bool $music): static
    {
        $this->music = $music;

        return $this;
    }

    public function isConversation(): ?bool
    {
        return $this->conversation;
    }

    public function setConversation(?bool $conversation): static
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function isPetsAllowed(): ?bool
    {
        return $this->pets_allowed;
    }

    public function setPetsAllowed(?bool $pets_allowed): static
    {
        $this->pets_allowed = $pets_allowed;

        return $this;
    }

    public function isAirConditioning(): ?bool
    {
        return $this->air_conditioning;
    }

    public function setAirConditioning(?bool $air_conditioning): static
    {
        $this->air_conditioning = $air_conditioning;

        return $this;
    }

    public function isSmoker(): ?bool
    {
        return $this->smoker;
    }

    public function setSmoker(?bool $smoker): static
    {
        $this->smoker = $smoker;

        return $this;
    }

    public function getCustomPreferences(): ?string
    {
        return $this->custom_preferences;
    }

    public function setCustomPreferences(?string $custom_preferences): static
    {
        $this->custom_preferences = $custom_preferences;

        return $this;
    }
}
