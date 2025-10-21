<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    /**
     * @var Collection<int, UserDonation>
     */
    #[ORM\OneToMany(targetEntity: UserDonation::class, mappedBy: 'donation')]
    private Collection $listUserDonation;

    public function __construct()
    {
        $this->listUserDonation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, UserDonation>
     */
    public function getlistUserDonation(): Collection
    {
        return $this->listUserDonation;
    }

    public function addlistUserDonation(UserDonation $listUserDonation): static
    {
        if (!$this->listUserDonation->contains($listUserDonation)) {
            $this->listUserDonation->add($listUserDonation);
            $listUserDonation->setDonation($this);
        }

        return $this;
    }

    public function removelistUserDonation(UserDonation $listUserDonation): static
    {
        if ($this->listUserDonation->removeElement($listUserDonation)) {
            // set the owning side to null (unless already changed)
            if ($listUserDonation->getDonation() === $this) {
                $listUserDonation->setDonation(null);
            }
        }

        return $this;
    }

}
