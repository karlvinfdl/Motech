<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\Table(name: 'service')]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_service')]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private string $prenom = '';

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $demandeSpecial = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: UtilisateurService::class)]
    private Collection $utilisateurServices;

    public function __construct()
    {
        $this->utilisateurServices = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): static { $this->prenom = $prenom; return $this; }

    public function getDemandeSpecial(): ?string { return $this->demandeSpecial; }
    public function setDemandeSpecial(?string $demandeSpecial): static { $this->demandeSpecial = $demandeSpecial; return $this; }

    public function getUtilisateurServices(): Collection { return $this->utilisateurServices; }
}
