<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createAt = null;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private ?int $credit = 0;

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private ?int $status = 1; // 0 = désactivé, 1 = actif, 2 = supprimé, 3 = en vérification

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserDonation::class)]
    private Collection $listUserDonation;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Anouncement::class)]
    private Collection $listAnouncements;

    public function __construct()
    {
        $this->listUserDonation = new ArrayCollection();
        $this->listAnouncements = new ArrayCollection();
        $this->createAt = new \DateTime(); // date par défaut
    }

    // --- GETTERS / SETTERS ---

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;
        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(?int $credit): static
    {
        $this->credit = $credit;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): static
    {
        $this->createAt = $createAt;
        return $this;
    }

    // --- RELATIONS ---

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
            if ($listAnouncement->getUser() === $this) {
                $listAnouncement->setUser(null);
            }
        }
        return $this;
    }

    // --- INTERFACES SÉCURITÉ SYMFONY ---

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        // On ajoute le rôle "ROLE_USER" par défaut
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si tu stockes des données sensibles temporaires, efface-les ici
    }
}
