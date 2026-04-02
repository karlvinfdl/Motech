<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CoasterController extends AbstractController
{
    #[Route('/coaster', name: 'app_coaster')]
    public function index(): Response
    {
        return $this->render('coaster/index.html.twig');
    }

    #[Route('/jouer', name: 'app_game')]
    public function jouer(): Response
    {
        return $this->render('coaster/game.html.twig');
    }
}