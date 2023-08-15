<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'nomComplet',length: 255, nullable: true)]
    private ?string $nomComplet = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(name:'messageContenu',type: Types::TEXT)]
    private ?string $messageContenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column]
    private ?int $lu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(?string $nomComplet): static
    {
        $this->nomComplet = $nomComplet;

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

    public function getMessageContenu(): ?string
    {
        return $this->messageContenu;
    }

    public function setMessageContenu(string $messageContenu): static
    {
        $this->messageContenu = $messageContenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLu(): ?int
    {
        return $this->lu;
    }

    public function setLu(int $lu): static
    {
        $this->lu = $lu;

        return $this;
    }
}
