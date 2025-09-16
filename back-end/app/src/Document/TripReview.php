<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: "trip_reviews")]
class TripReview
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: "string")]
    private string $tripId;

    #[MongoDB\Field(type: "string")]
    private string $userId;

    #[MongoDB\Field(type: "string")]
    private string $comment;

    #[MongoDB\Field(type: "int")]
    private int $rating;

    #[MongoDB\Field(type: "date")]
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime(); // initialise automatiquement la date
    }

    // --------------------------
    // Getters
    // --------------------------
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTripId(): string
    {
        return $this->tripId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    // --------------------------
    // Setters
    // --------------------------
    public function setTripId(string $tripId): self
    {
        $this->tripId = $tripId;
        return $this;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt instanceof \DateTime ? $createdAt : new \DateTime($createdAt->format('Y-m-d H:i:s'));
        return $this;
    }
}
