<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $birthDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $postalAddress = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $creadits = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePhotoUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    // === GETTERS & SETTERS ===

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getPostalAddress(): ?string
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(?string $postalAddress): static
    {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getCreadits(): ?int
    {
        return $this->creadits;
    }

    public function setCreadits(int $creadits): static
    {
        $this->creadits = $creadits;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getProfilePhotoUrl(): ?string
    {
        return $this->profilePhotoUrl;
    }

    public function setProfilePhotoUrl(?string $profilePhotoUrl): static
    {
        $this->profilePhotoUrl = $profilePhotoUrl;
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

    // === MÉTHODES OBLIGATOIRES POUR SYMFONY SECURITY ===

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        // ton champ est "role" (string) → on l’emballe dans un tableau
        $roles = [$this->role ?? 'ROLE_PASSENGER'];
        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // Si tu stockes des données sensibles temporaires (ex: plainPassword)
    }
}
