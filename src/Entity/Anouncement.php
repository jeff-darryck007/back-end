<?php

namespace App\Entity;

use App\Repository\AnouncementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnouncementRepository::class)]
class Anouncement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pictures = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $adress = null;

    #[ORM\Column]
    private ?float $postX = null;

    #[ORM\Column]
    private ?float $postY = null;

    #[ORM\Column]
    private ?float $postZ = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createAt = null;

    #[ORM\ManyToOne(inversedBy: 'listAnouncements')]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPictures(): ?string
    {
        return $this->pictures;
    }

    public function setPictures(string $pictures): static
    {
        $this->pictures = $pictures;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostX(): ?float
    {
        return $this->postX;
    }

    public function setPostX(float $postX): static
    {
        $this->postX = $postX;

        return $this;
    }

    public function getPostY(): ?float
    {
        return $this->postY;
    }

    public function setPostY(float $postY): static
    {
        $this->postY = $postY;

        return $this;
    }

    public function getPostZ(): ?float
    {
        return $this->postZ;
    }

    public function setPostZ(float $postZ): static
    {
        $this->postZ = $postZ;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTime $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
