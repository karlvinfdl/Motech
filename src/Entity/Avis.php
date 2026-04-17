<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ORM\Table(name: 'avis')]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_avis')]
    private ?int $id = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $jeuPrefere = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeImmutable $dateCreation;

    #[ORM\Column(nullable: true)]
    private ?int $note = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'avis')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur', nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $message): static { $this->message = $message; return $this; }

    public function getJeuPrefere(): ?string { return $this->jeuPrefere; }
    public function setJeuPrefere(?string $jeuPrefere): static { $this->jeuPrefere = $jeuPrefere; return $this; }

    public function getDateCreation(): \DateTimeImmutable { return $this->dateCreation; }
    public function setDateCreation(\DateTimeImmutable $dateCreation): static { $this->dateCreation = $dateCreation; return $this; }

    public function getNote(): ?int { return $this->note; }
    public function setNote(?int $note): static { $this->note = $note; return $this; }

    public function getUtilisateur(): ?Utilisateur { return $this->utilisateur; }
    public function setUtilisateur(?Utilisateur $utilisateur): static { $this->utilisateur = $utilisateur; return $this; }
}
