<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Word>
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    /** @return array<string, string[]> Words grouped by difficulty */
    public function findGroupedByDifficulty(): array
    {
        $words = $this->findAll();

        $grouped = ['facile' => [], 'moyen' => [], 'difficile' => []];
        foreach ($words as $word) {
            $grouped[$word->getDifficulty()][] = $word->getWord();
        }
        return $grouped;
    }

    /** @return array<string, string> Hint map: word => hint */
    public function findHintMap(): array
    {
        $map = [];
        foreach ($this->findAll() as $word) {
            if ($word->getHint() !== null) {
                $map[$word->getWord()] = $word->getHint();
            }
        }
        return $map;
    }
}
