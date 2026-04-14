<?php

namespace App\Controller;

use App\Entity\Professionnel;
use App\Entity\Service;
use App\Entity\Utilisateur;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        RequestStack $requestStack,
        ServiceRepository $serviceRepository
    ): Response {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('equipe_form', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException('Token CSRF invalide.');
            }

            $session = $requestStack->getSession();
            $idUtilisateur = $session->get('id_utilisateur');

            // Récupère l'utilisateur en session ou en crée un nouveau depuis le formulaire
            if ($idUtilisateur) {
                $utilisateur = $em->find(Utilisateur::class, $idUtilisateur);
            } else {
                $email = trim($request->request->get('email', ''));
                $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

                if (!$utilisateur) {
                    $utilisateur = new Utilisateur();
                    $utilisateur->setEmail($email);
                    $utilisateur->setNom(trim($request->request->get('nom', '')));
                    $utilisateur->setPrenom(trim($request->request->get('prenom', '')));
                    $em->persist($utilisateur);
                    $em->flush();
                }

                $session->set('id_utilisateur', $utilisateur->getId());
            }

            // Crée ou met à jour le profil professionnel
            $professionnel = $utilisateur->getProfessionnel();
            if (!$professionnel) {
                $professionnel = new Professionnel();
                $professionnel->setUtilisateur($utilisateur);
            }

            $professionnel->setSiret($request->request->get('siret') ?: null);
            $professionnel->setSiteWeb($request->request->get('site_web') ?: null);
            $professionnel->setClassification($request->request->get('classification') ?: null);
            $professionnel->setNotes($request->request->get('notes') ?: null);

            // Lie les services cochés (findOrCreate)
            $servicesSelectionnes = $request->request->all()['services'] ?? [];
            $professionnel->getServices()->clear();

            foreach ($servicesSelectionnes as $nomService) {
                $service = $serviceRepository->findOneBy(['nom' => $nomService]);
                if (!$service) {
                    $service = new Service();
                    $service->setNom($nomService);
                    $em->persist($service);
                }
                $professionnel->addService($service);
            }

            $em->persist($professionnel);
            $em->flush();

            return $this->redirectToRoute('app_avis');
        }

        return $this->render('equipe/index.html.twig');
    }
}
