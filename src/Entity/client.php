<?php

namespace App\Entity;

use App\Repository\clientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: clientRepository::class)]
class client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nomClient',length: 255)]
    #[Groups(['list'])]
    private ?string $nomClient = null;

    #[ORM\Column(name: 'prenomClient',length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $prenomClient = null;
    #[ORM\Column(name: 'phone',length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $email = null;
    
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: siteClient::class, orphanRemoval: true)]
    private Collection $siteClients;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: TicketClient::class)]
    private Collection $ticketClients;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: TicketReplay::class, orphanRemoval: true)]
    private Collection $ticketReplays;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: Review::class)]
    private Collection $reviews;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->siteClients = new ArrayCollection();
        $this->ticketClients = new ArrayCollection();
        $this->ticketReplays = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(?string $prenomClient): static
    {
        $this->prenomClient = $prenomClient;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setIdClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIdClient() === $this) {
                $commande->setIdClient(null);
            }
        }

        return $this;
    }



    public function addSiteClient(SiteClient $siteClient): static
    {
        if (!$this->siteClients->contains($siteClient)) {
            $this->siteClients->add($siteClient);
            $siteClient->setIdClient($this);
        }

        return $this;
    }

    public function removeSiteClient(SiteClient $siteClient): static
    {
        if ($this->siteClients->removeElement($siteClient)) {
            // set the owning side to null (unless already changed)
            if ($siteClient->getIdClient() === $this) {
                $siteClient->setIdClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TicketClient>
     */
    public function getTicketClients(): Collection
    {
        return $this->ticketClients;
    }

    public function addTicketClient(TicketClient $ticketClient): static
    {
        if (!$this->ticketClients->contains($ticketClient)) {
            $this->ticketClients->add($ticketClient);
            $ticketClient->setIdClient($this);
        }

        return $this;
    }

    public function removeTicketClient(TicketClient $ticketClient): static
    {
        if ($this->ticketClients->removeElement($ticketClient)) {
            // set the owning side to null (unless already changed)
            if ($ticketClient->getIdClient() === $this) {
                $ticketClient->setIdClient(null);
            }
        }

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
            $ticketReplay->setIdClient($this);
        }

        return $this;
    }

    public function removeTicketReplay(TicketReplay $ticketReplay): static
    {
        if ($this->ticketReplays->removeElement($ticketReplay)) {
            // set the owning side to null (unless already changed)
            if ($ticketReplay->getIdClient() === $this) {
                $ticketReplay->setIdClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setIdClient($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getIdClient() === $this) {
                $review->setIdClient(null);
            }
        }

        return $this;
    }
}
