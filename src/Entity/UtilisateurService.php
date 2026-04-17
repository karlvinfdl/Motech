<?php

namespace App\Entity;

use App\Repository\UtilisateurServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurServiceRepository::class)]
#[ORM\Table(name: 'utilisateurs_service')]
class UtilisateurService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_utilisateur_service')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'utilisateurServices')]
    #[ORM\JoinColumn(name: 'id_utilisateurs', referencedColumnName: 'id_utilisateur', nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'utilisateurServices')]
    #[ORM\JoinColumn(name: 'id_service', referencedColumnName: 'id_service', nullable: false)]
    private ?Service $service = null;

    public function getId(): ?int { return $this->id; }

    public function getUtilisateur(): ?Utilisateur { return $this->utilisateur; }
    public function setUtilisateur(?Utilisateur $utilisateur): static { $this->utilisateur = $utilisateur; return $this; }

    public function getService(): ?Service { return $this->service; }
    public function setService(?Service $service): static { $this->service = $service; return $this; }
}
