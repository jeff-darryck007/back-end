<?php

namespace App\Entity;

use App\Repository\UserDonationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDonationRepository::class)]
class UserDonation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # relation de cle etrangere avec la table donation
    #[ORM\ManyToOne(inversedBy: 'listDonation')]
    private ?Donation $donation = null;

    # relation de cle etrangere avec la table user
    #[ORM\ManyToOne(inversedBy: 'listUserDonation')]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonation(): ?Donation
    {
        return $this->donation;
    }

    public function setDonation(?Donation $donation): static
    {
        $this->donation = $donation;

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
