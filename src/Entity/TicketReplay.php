<?php

namespace App\Entity;

use App\Repository\TicketReplayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketReplayRepository::class)]
class TicketReplay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ticketReplays')]
    #[ORM\JoinColumn(name:'idTicket',nullable: false)]
    private ?ticketClient $id_ticket = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'ticketReplays')]
    #[ORM\JoinColumn(name:'id_client',nullable: false)]
    private ?client $id_client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTicket(): ?ticketClient
    {
        return $this->id_ticket;
    }

    public function setIdTicket(?ticketClient $id_ticket): static
    {
        $this->id_ticket = $id_ticket;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

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
}
