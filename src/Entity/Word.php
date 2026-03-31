<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordRepository::class)]
#[ORM\Table(name: 'word')]
class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private string $word = '';

    #[ORM\Column(length: 10)]
    private string $difficulty = 'easy';

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $hint = null;

    public function getId(): ?int { return $this->id; }

    public function getWord(): string { return $this->word; }
    public function setWord(string $word): static { $this->word = strtoupper($word); return $this; }

    public function getDifficulty(): string { return $this->difficulty; }
    public function setDifficulty(string $difficulty): static { $this->difficulty = $difficulty; return $this; }

    public function getHint(): ?string { return $this->hint; }
    public function setHint(?string $hint): static { $this->hint = $hint; return $this; }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'word'       => $this->word,
            'difficulty' => $this->difficulty,
            'hint'       => $this->hint,
        ];
    }
}
