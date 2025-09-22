<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: "trip_reviews")]
class TripReview
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: "string")]
    private ?string $tripId = null;

    #[MongoDB\Field(type: "string")]
    private ?string $userId = null;

    #[MongoDB\Field(type: "string")]
    private ?string $userPseudo = null;

    #[MongoDB\Field(type: "string")]
    private ?string $comment = null;

    #[MongoDB\Field(type: "int")]
    private ?int $rating = null;

    #[MongoDB\Field(type: "date")]
    private ?\DateTime $createdAt = null;

    // --- Getters / Setters ---
    public function getId(): ?string { return $this->id; }

    public function getTripId(): ?string { return $this->tripId; }
    public function setTripId(string $tripId): static { $this->tripId = $tripId; return $this; }

    public function getUserId(): ?string { return $this->userId; }
    public function setUserId(string $userId): static { $this->userId = $userId; return $this; }

    public function getUserPseudo(): ?string { return $this->userPseudo; }
    public function setUserPseudo(string $userPseudo): static { $this->userPseudo = $userPseudo; return $this; }

    public function getComment(): ?string { return $this->comment; }
    public function setComment(string $comment): static { $this->comment = $comment; return $this; }

    public function getRating(): ?int { return $this->rating; }
    public function setRating(int $rating): static { $this->rating = $rating; return $this; }

    public function getCreatedAt(): ?\DateTime { return $this->createdAt; }
    public function setCreatedAt(\DateTime $createdAt): static { $this->createdAt = $createdAt; return $this; }
}
