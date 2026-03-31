<?php

namespace App\Controller;

use App\Entity\Score;
use App\Repository\ScoreRepository;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ScrabbleController extends AbstractController
{
    #[Route('/scrabble', name: 'app_scrabble')]
    public function index(): Response
    {
        return $this->render('scrabble/index.html.twig', [
            'controller_name' => 'ScrabbleController',
        ]);
    }

    #[Route('/jeux/api/mots', name: 'jeux_api_mots', methods: ['GET'])]
    public function apiMots(WordRepository $wordRepository): JsonResponse
    {
        return $this->json([
            'regles' => [
                'easy'   => ['ptsWord' => 8,  'bonusTemps' => 1, 'tickets' => 1],
                'medium' => ['ptsWord' => 12, 'bonusTemps' => 2, 'tickets' => 2],
                'hard'   => ['ptsWord' => 18, 'bonusTemps' => 3, 'tickets' => 3],
            ],
            'mots'    => $wordRepository->findGroupedByDifficulty(),
            'indices' => $wordRepository->findHintMap(),
        ]);
    }

    #[Route('/jeux/score/save', name: 'jeux_score_save', methods: ['POST'])]
    public function scoreSave(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];

        $score = (new Score())
            ->setPlayer(substr(strip_tags($payload['player'] ?? 'Joueur'), 0, 60))
            ->setScore((int) ($payload['score']  ?? 0))
            ->setWin((bool) ($payload['win']     ?? false))
            ->setFound((int) ($payload['found']  ?? 0))
            ->setTarget((int) ($payload['target'] ?? 10));

        $em->persist($score);
        $em->flush();

        return $this->json(['ok' => true, 'id' => $score->getId()]);
    }

    #[Route('/jeux/api/scores', name: 'jeux_api_scores', methods: ['GET'])]
    public function apiScores(ScoreRepository $scoreRepository): JsonResponse
    {
        $scores = array_map(
            fn(Score $s) => $s->toArray(),
            $scoreRepository->findTopScores(20)
        );
        return $this->json($scores);
    }
}
