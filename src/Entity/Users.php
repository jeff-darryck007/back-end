<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createAt = null;

    #[ORM\Column(length: 255)]
    private ?int $credit = null;

    #[ORM\Column(length: 255)]
    private ?int $status = null;

    /**
     * @var Collection<int, UserDonation>
     */
    #[ORM\OneToMany(targetEntity: UserDonation::class, mappedBy: 'user')]
    private Collection $listUserDonation;

    /**
     * @var Collection<int, Anouncement>
     */
    #[ORM\OneToMany(targetEntity: Anouncement::class, mappedBy: 'user')]
    private Collection $listAnouncements;

    public function __construct()
    {
        $this->listUserDonation = new ArrayCollection();
        $this->listAnouncements = new ArrayCollection();
    } # 0 = desactiver 1= activer 2= supprimer 3= verification

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): static
    {
        $this->credit = $credit;

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

    /**
     * @return Collection<int, UserDonation>
     */
    public function getListUserDonation(): Collection
    {
        return $this->listUserDonation;
    }

    public function addListUserDonation(UserDonation $listUserDonation): static
    {
        if (!$this->listUserDonation->contains($listUserDonation)) {
            $this->listUserDonation->add($listUserDonation);
            $listUserDonation->setUser($this);
        }

        return $this;
    }

    public function removeListUserDonation(UserDonation $listUserDonation): static
    {
        if ($this->listUserDonation->removeElement($listUserDonation)) {
            // set the owning side to null (unless already changed)
            if ($listUserDonation->getUser() === $this) {
                $listUserDonation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Anouncement>
     */
    public function getListAnouncements(): Collection
    {
        return $this->listAnouncements;
    }

    public function addListAnouncement(Anouncement $listAnouncement): static
    {
        if (!$this->listAnouncements->contains($listAnouncement)) {
            $this->listAnouncements->add($listAnouncement);
            $listAnouncement->setUser($this);
        }

        return $this;
    }

    public function removeListAnouncement(Anouncement $listAnouncement): static
    {
        if ($this->listAnouncements->removeElement($listAnouncement)) {
            // set the owning side to null (unless already changed)
            if ($listAnouncement->getUser() === $this) {
                $listAnouncement->setUser(null);
            }
        }

        return $this;
    }

}
