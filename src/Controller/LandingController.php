<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LandingController extends AbstractController
{
    #[Route('/', name: 'app_landing')]
    public function home(): Response
    {
        return $this->render('landing/index.html.twig');
    }

    #[Route('/equipe', name: 'app_equipe')]
    public function equipe(): Response
    {
        return $this->render('equipe/index.html.twig');
    }

    #[Route('/avis', name: 'app_avis')]
    public function fin(): Response
    {
        return $this->render('avis/index.html.twig');
    }

    #[Route('/wheel', name: 'app_wheel')]
    public function wheel(): Response
    {
        return $this->render('wheel/index.html.twig');
    }

    #[Route('/devinelemot', name: 'app_devinelemot')]
    public function devinelemot(): Response
    {
        return $this->render('devinelemot/index.html.twig');
    }

    #[Route('/pinata', name: 'app_ptinata')]
    public function pinata(): Response
    {
        return $this->render('ptinata/index.html.twig');
    }

    #[Route('/scrabble', name: 'app_scrabble')]
    public function scrabble(): Response
    {
        return $this->render('scrabble/index.html.twig');
    }

    #[Route('/coaster', name: 'app_coaster')]
    public function coaster(): Response
    {
        return $this->render('coaster/index.html.twig');
    }

}
