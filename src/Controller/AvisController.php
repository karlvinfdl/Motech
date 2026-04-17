<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        RequestStack $requestStack
    ): Response {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('avis_form', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException('Token CSRF invalide.');
            }

            $session = $requestStack->getSession();
            $email   = trim($request->request->get('email', ''));
            $prenom  = trim($request->request->get('prenom', ''));
            $message = trim($request->request->get('message', ''));
            $jeuPref = $request->request->get('jeu_prefere') ?: null;
            $note    = (int) $request->request->get('note', 0);

            // Récupère l'utilisateur : session > email > nouveau
            $idUtilisateur = $session->get('id_utilisateur');
            $utilisateur   = null;

            if ($idUtilisateur) {
                $utilisateur = $em->find(Utilisateur::class, $idUtilisateur);
            }

            if (!$utilisateur && $email) {
                $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
            }

            if (!$utilisateur) {
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($email);
                $utilisateur->setNom('');
                $utilisateur->setPrenom($prenom);
                $em->persist($utilisateur);
                $em->flush();
                $session->set('id_utilisateur', $utilisateur->getId());
            }

            $avis = new Avis();
            $avis->setMessage($message);
            $avis->setJeuPrefere($jeuPref);
            $avis->setNote($note > 0 ? $note : null);
            $avis->setUtilisateur($utilisateur);

            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', 'Merci pour ton avis !');
            return $this->redirectToRoute('app_avis');
        }

        $avisList = $em->getRepository(Avis::class)->findBy([], ['dateCreation' => 'DESC']);

        return $this->render('avis/index.html.twig', [
            'avis_list' => $avisList,
        ]);
    }
}
