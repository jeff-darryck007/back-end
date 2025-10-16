<?php

namespace App\Entity;

use App\Repository\UserSubscribeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSubscribeRepository::class)]
class UserSubscribe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Subscribe $soubcribe = null;

    #[ORM\ManyToOne]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoubcribe(): ?Subscribe
    {
        return $this->soubcribe;
    }

    public function setSoubcribe(?Subscribe $soubcribe): static
    {
        $this->soubcribe = $soubcribe;

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
