<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
#[ORM\Table(name: 'score')]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private string $player = '';

    #[ORM\Column]
    private int $score = 0;

    #[ORM\Column]
    private bool $win = false;

    #[ORM\Column]
    private int $found = 0;

    #[ORM\Column]
    private int $target = 10;

    #[ORM\Column]
    private \DateTimeImmutable $playedAt;

    public function __construct()
    {
        $this->playedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getPlayer(): string { return $this->player; }
    public function setPlayer(string $player): static { $this->player = $player; return $this; }

    public function getScore(): int { return $this->score; }
    public function setScore(int $score): static { $this->score = $score; return $this; }

    public function isWin(): bool { return $this->win; }
    public function setWin(bool $win): static { $this->win = $win; return $this; }

    public function getFound(): int { return $this->found; }
    public function setFound(int $found): static { $this->found = $found; return $this; }

    public function getTarget(): int { return $this->target; }
    public function setTarget(int $target): static { $this->target = $target; return $this; }

    public function getPlayedAt(): \DateTimeImmutable { return $this->playedAt; }
    public function setPlayedAt(\DateTimeImmutable $playedAt): static { $this->playedAt = $playedAt; return $this; }

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'player'   => $this->player,
            'score'    => $this->score,
            'win'      => $this->win,
            'found'    => $this->found,
            'target'   => $this->target,
            'playedAt' => $this->playedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
