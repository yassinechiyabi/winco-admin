<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
class plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_plan = null;

    #[ORM\Column(length: 2000)]
    private ?string $desc_plan = null;

    #[ORM\Column]
    private ?int $nbr_modification = null;

    #[ORM\Column]
    private ?int $nbr_page = null;

    #[ORM\Column]
    private ?int $nbr_post = null;

    #[ORM\Column]
    private ?int $prix_mensuel_plan = null;

    #[ORM\Column(name:'prix_miseEnLigne_plan')]
    private ?int $prix_miseEnLigne_plan = null;

    #[ORM\Column(name:'isActive')]
    private ?int $isActive = null;

    #[ORM\OneToMany(mappedBy: 'id_plan', targetEntity: Commande::class,orphanRemoval:true)]
    private Collection $yes;

    #[ORM\OneToMany(mappedBy: 'id_plan', targetEntity: siteClient::class,orphanRemoval:true)]
    private Collection $plan;

    #[ORM\OneToMany(mappedBy: 'id_plan', targetEntity: RandomCommande::class)]
    private Collection $randomCommandes;

    public function __construct()
    {
        $this->yes = new ArrayCollection();
        $this->plan = new ArrayCollection();
        $this->randomCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPlan(): ?string
    {
        return $this->nom_plan;
    }

    public function setNomPlan(string $nom_plan): static
    {
        $this->nom_plan = $nom_plan;

        return $this;
    }

    public function getDescPlan(): ?string
    {
        return $this->desc_plan;
    }

    public function setDescPlan(string $desc_plan): static
    {
        $this->desc_plan = $desc_plan;

        return $this;
    }

    public function getNbrModification(): ?int
    {
        return $this->nbr_modification;
    }

    public function setNbrModification(int $nbr_modification): static
    {
        $this->nbr_modification = $nbr_modification;

        return $this;
    }

    public function getNbrPage(): ?int
    {
        return $this->nbr_page;
    }

    public function setNbrPage(int $nbr_page): static
    {
        $this->nbr_page = $nbr_page;

        return $this;
    }

    public function getNbrPost(): ?int
    {
        return $this->nbr_post;
    }

    public function setNbrPost(int $nbr_post): static
    {
        $this->nbr_post = $nbr_post;

        return $this;
    }

    public function getPrixMensuelPlan(): ?int
    {
        return $this->prix_mensuel_plan;
    }

    public function setPrixMensuelPlan(int $prix_mensuel_plan): static
    {
        $this->prix_mensuel_plan = $prix_mensuel_plan;

        return $this;
    }

    public function getPrixMiseEnLignePlan(): ?int
    {
        return $this->prix_miseEnLigne_plan;
    }

    public function setPrixMiseEnLignePlan(int $prix_miseEnLigne_plan): static
    {
        $this->prix_miseEnLigne_plan = $prix_miseEnLigne_plan;

        return $this;
    }

    public function getIsActive(): ?int
    {
        return $this->isActive;
    }

    public function setIsActive(int $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    

    public function addYe(Commande $ye): static
    {
        if (!$this->yes->contains($ye)) {
            $this->yes->add($ye);
            $ye->setIdPlan($this);
        }

        return $this;
    }

    public function removeYe(Commande $ye): static
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getIdPlan() === $this) {
                $ye->setIdPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SiteClient>
     */
    

    public function addPlan(SiteClient $plan): static
    {
        if (!$this->plan->contains($plan)) {
            $this->plan->add($plan);
            $plan->setIdPlan($this);
        }

        return $this;
    }

    public function removePlan(SiteClient $plan): static
    {
        if ($this->plan->removeElement($plan)) {
            // set the owning side to null (unless already changed)
            if ($plan->getIdPlan() === $this) {
                $plan->setIdPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RandomCommande>
     */
    public function getRandomCommandes(): Collection
    {
        return $this->randomCommandes;
    }

    public function addRandomCommande(RandomCommande $randomCommande): static
    {
        if (!$this->randomCommandes->contains($randomCommande)) {
            $this->randomCommandes->add($randomCommande);
            $randomCommande->setIdPlan($this);
        }

        return $this;
    }

    public function removeRandomCommande(RandomCommande $randomCommande): static
    {
        if ($this->randomCommandes->removeElement($randomCommande)) {
            // set the owning side to null (unless already changed)
            if ($randomCommande->getIdPlan() === $this) {
                $randomCommande->setIdPlan(null);
            }
        }

        return $this;
    }
}
