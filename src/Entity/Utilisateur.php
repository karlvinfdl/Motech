<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_utilisateur')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $nom = '';

    #[ORM\Column(length: 60)]
    private string $prenom = '';

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 100, unique: true)]
    private string $email = '';

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $dateInscription;

    #[ORM\OneToOne(mappedBy: 'utilisateur', targetEntity: Professionnel::class, cascade: ['persist', 'remove'])]
    private ?Professionnel $professionnel = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Avis::class, cascade: ['persist', 'remove'])]
    private Collection $avis;

    public function __construct()
    {
        $this->dateInscription = new \DateTime();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): static { $this->prenom = $prenom; return $this; }

    public function getDateNaissance(): ?\DateTimeInterface { return $this->dateNaissance; }
    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static { $this->dateNaissance = $dateNaissance; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getVille(): ?string { return $this->ville; }
    public function setVille(?string $ville): static { $this->ville = $ville; return $this; }

    public function getGenre(): ?string { return $this->genre; }
    public function setGenre(?string $genre): static { $this->genre = $genre; return $this; }

    public function getDateInscription(): \DateTimeInterface { return $this->dateInscription; }
    public function setDateInscription(\DateTimeInterface $dateInscription): static { $this->dateInscription = $dateInscription; return $this; }

    public function getProfessionnel(): ?Professionnel { return $this->professionnel; }
    public function setProfessionnel(?Professionnel $professionnel): static
    {
        if ($professionnel !== null) {
            $professionnel->setUtilisateur($this);
        }
        $this->professionnel = $professionnel;
        return $this;
    }

    public function getAvis(): Collection { return $this->avis; }
    public function addAvis(Avis $avis): static
    {
        if (!$this->avis->contains($avis)) {
            $this->avis->add($avis);
            $avis->setUtilisateur($this);
        }
        return $this;
    }
    public function removeAvis(Avis $avis): static
    {
        $this->avis->removeElement($avis);
        return $this;
    }
}
