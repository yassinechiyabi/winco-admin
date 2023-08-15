<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $domaine = null;

    #[ORM\Column(name:'nomSite',length: 255)]
    private ?string $nomSite = null;

    #[ORM\Column(name:'typeSite',length: 255, nullable: true)]
    private ?string $typeSite = null;

    #[ORM\Column(name:'descSite',length: 255, nullable: true)]
    private ?string $descSite = null;

    #[ORM\Column]
    private ?int $Etat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(name:'id_client',nullable: false)]
    private ?client $id_client = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    #[ORM\JoinColumn(name:'id_plan',nullable: false)]
    private ?plan $id_plan = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getNomSite(): ?string
    {
        return $this->nomSite;
    }

    public function setNomSite(string $nomSite): static
    {
        $this->nomSite = $nomSite;

        return $this;
    }

    public function getTypeSite(): ?string
    {
        return $this->typeSite;
    }

    public function setTypeSite(?string $typeSite): static
    {
        $this->typeSite = $typeSite;

        return $this;
    }

    public function getDescSite(): ?string
    {
        return $this->descSite;
    }

    public function setDescSite(?string $descSite): static
    {
        $this->descSite = $descSite;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->Etat;
    }

    public function setEtat(int $Etat): static
    {
        $this->Etat = $Etat;

        return $this;
    }


    

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getIdClient(): ?client
    {
        return $this->id_client;
    }

    public function setIdClient(?client $id_client): static
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getIdPlan(): ?plan
    {
        return $this->id_plan;
    }

    public function setIdPlan(?plan $id_plan): static
    {
        $this->id_plan = $id_plan;

        return $this;
    }
}
