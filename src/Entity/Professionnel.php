<?php

namespace App\Entity;

use App\Repository\ProfessionnelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionnelRepository::class)]
#[ORM\Table(name: 'professionnel')]
class Professionnel
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'professionnel', targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur', nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(length: 17, unique: true, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $classification = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'professionnels')]
    #[ORM\JoinTable(
        name: 'professionnel_service',
        joinColumns: [new ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'id_service', referencedColumnName: 'id_service')]
    )]
    private Collection $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getUtilisateur(): ?Utilisateur { return $this->utilisateur; }
    public function setUtilisateur(?Utilisateur $utilisateur): static { $this->utilisateur = $utilisateur; return $this; }

    public function getSiret(): ?string { return $this->siret; }
    public function setSiret(?string $siret): static { $this->siret = $siret; return $this; }

    public function getSiteWeb(): ?string { return $this->siteWeb; }
    public function setSiteWeb(?string $siteWeb): static { $this->siteWeb = $siteWeb; return $this; }

    public function getClassification(): ?string { return $this->classification; }
    public function setClassification(?string $classification): static { $this->classification = $classification; return $this; }

    public function getNotes(): ?string { return $this->notes; }
    public function setNotes(?string $notes): static { $this->notes = $notes; return $this; }

    public function getServices(): Collection { return $this->services; }
    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
        }
        return $this;
    }
    public function removeService(Service $service): static
    {
        $this->services->removeElement($service);
        return $this;
    }
}
