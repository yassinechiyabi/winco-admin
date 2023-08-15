<?php

namespace App\Entity;

use App\Repository\TicketClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketClientRepository::class)]
class TicketClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(name:'niveauUrgence')]
    private ?int $NiveauUrgence = null;

    #[ORM\ManyToOne(inversedBy: 'ticketClients')]
    #[ORM\JoinColumn(name:'id_client',nullable: false)]
    private ?client $id_client = null;

    #[ORM\ManyToOne(inversedBy: 'ticketClients')]
    #[ORM\JoinColumn(name:'idSite',nullable: false)]
    private ?siteClient $id_site = null;

    #[ORM\Column(name:'contenuTicket',type: Types::TEXT)]
    private ?string $contenuTicket = null;

    #[ORM\Column]
    private ?int $Etat = null;

    #[ORM\OneToMany(mappedBy: 'id_ticket', targetEntity: TicketReplay::class,orphanRemoval:true)]
    private Collection $ticketReplays;

    public function __construct()
    {
        $this->ticketReplays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNiveauUrgence(): ?int
    {
        return $this->NiveauUrgence;
    }

    public function setNiveauUrgence(int $NiveauUrgence): static
    {
        $this->NiveauUrgence = $NiveauUrgence;

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

    public function getIdSite(): ?siteClient
    {
        return $this->id_site;
    }

    public function setIdSite(?siteClient $id_site): static
    {
        $this->id_site = $id_site;

        return $this;
    }

    public function getContenuTicket(): ?string
    {
        return $this->contenuTicket;
    }

    public function setContenuTicket(string $contenuTicket): static
    {
        $this->contenuTicket = $contenuTicket;

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

    /**
     * @return Collection<int, TicketReplay>
     */
    public function getTicketReplays(): Collection
    {
        return $this->ticketReplays;
    }

    public function addTicketReplay(TicketReplay $ticketReplay): static
    {
        if (!$this->ticketReplays->contains($ticketReplay)) {
            $this->ticketReplays->add($ticketReplay);
            $ticketReplay->setIdTicket($this);
        }

        return $this;
    }

    public function removeTicketReplay(TicketReplay $ticketReplay): static
    {
        if ($this->ticketReplays->removeElement($ticketReplay)) {
            // set the owning side to null (unless already changed)
            if ($ticketReplay->getIdTicket() === $this) {
                $ticketReplay->setIdTicket(null);
            }
        }

        return $this;
    }
}
