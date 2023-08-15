<?php

namespace App\Entity;

use App\Repository\SiteClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteClientRepository::class)]
class siteClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $nom_site = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $description_site = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $domaine_site = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $type_site = null;

    

    #[ORM\Column(name:'showMain')]
    private ?int $showMain = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $images_url = null;

    #[ORM\ManyToOne(inversedBy: 'siteClient')]
    #[ORM\JoinColumn(name:'id_client',nullable: false)]
    private ?client $id_client = null;

    #[ORM\ManyToOne(inversedBy: 'plan')]
    #[ORM\JoinColumn(name:'id_plan',nullable: false)]
    #[Groups(['list'])]
    private ?plan $id_plan = null;

    #[ORM\OneToMany(mappedBy: 'id_site', targetEntity: TicketClient::class,orphanRemoval:true)]
    private Collection $ticketClients;

    public function __construct()
    {
        $this->ticketClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSite(): ?string
    {
        return $this->nom_site;
    }

    public function setNomSite(string $nom_site): static
    {
        $this->nom_site = $nom_site;

        return $this;
    }

    public function getDescriptionSite(): ?string
    {
        return $this->description_site;
    }

    public function setDescriptionSite(?string $description_site): static
    {
        $this->description_site = $description_site;

        return $this;
    }

    public function getDomaineSite(): ?string
    {
        return $this->domaine_site;
    }

    public function setDomaineSite(string $domaine_site): static
    {
        $this->domaine_site = $domaine_site;

        return $this;
    }

    public function getTypeSite(): ?string
    {
        return $this->type_site;
    }

    public function setTypeSite(?string $type_site): static
    {
        $this->type_site = $type_site;

        return $this;
    }

    

    public function getShowMain(): ?int
    {
        return $this->showMain;
    }

    public function setShowMain(int $showMain): static
    {
        $this->showMain = $showMain;

        return $this;
    }

    public function getImagesUrl(): ?string
    {
        return $this->images_url;
    }

    public function setImagesUrl(?string $images_url): static
    {
        $this->images_url = $images_url;

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
            $ticketClient->setIdSite($this);
        }

        return $this;
    }

    public function removeTicketClient(TicketClient $ticketClient): static
    {
        if ($this->ticketClients->removeElement($ticketClient)) {
            // set the owning side to null (unless already changed)
            if ($ticketClient->getIdSite() === $this) {
                $ticketClient->setIdSite(null);
            }
        }

        return $this;
    }
}
