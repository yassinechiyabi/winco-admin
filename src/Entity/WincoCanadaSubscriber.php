<?php

namespace App\Entity;

use App\Repository\WincoCanadaSubscriberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WincoCanadaSubscriberRepository::class)]
class WincoCanadaSubscriber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_email = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseEmail(): ?string
    {
        return $this->adresse_email;
    }

    public function setAdresseEmail(string $adresse_email): static
    {
        $this->adresse_email = $adresse_email;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
