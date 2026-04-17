<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LandingController extends AbstractController
{
    #[Route('/', name: 'app_landing', methods: ['GET', 'POST'])]
    public function home(Request $request, EntityManagerInterface $em, RequestStack $requestStack): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('landing_form', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException('Token CSRF invalide.');
            }

            $email = trim($request->request->get('email', ''));

            // Réutilise l'utilisateur existant si l'email est déjà enregistré
            $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

            if (!$utilisateur) {
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($email);
            }

            $utilisateur->setNom(trim($request->request->get('nom', '')));
            $utilisateur->setPrenom(trim($request->request->get('prenom', '')));
            $utilisateur->setVille($request->request->get('ville') ?: null);

            $age = (int) $request->request->get('age', 0);
            if ($age > 0) {
                $utilisateur->setDateNaissance(new \DateTime("-{$age} years"));
            }

            $em->persist($utilisateur);
            $em->flush();

            $requestStack->getSession()->set('id_utilisateur', $utilisateur->getId());

            return $this->redirectToRoute('app_landing');
        }

        $services = $em->getRepository(Service::class)->findAll();

        return $this->render('landing/index.html.twig', ['services' => $services]);
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
