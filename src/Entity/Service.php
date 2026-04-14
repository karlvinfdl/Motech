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
    private string $nom = '';

    #[ORM\ManyToMany(targetEntity: Professionnel::class, mappedBy: 'services')]
    private Collection $professionnels;

    public function __construct()
    {
        $this->professionnels = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getProfessionnels(): Collection { return $this->professionnels; }
}
