<?php

namespace App\Controller;

use App\Entity\Newsletter\Newsletters;
use App\Entity\Newsletter\Users;
use App\Form\NewsletterUsersType;
use App\Form\NewsletterType;
use App\Repository\Newsletter\NewslettersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class NewsletterController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(NewsletterUsersType::class, $user);

        // Traitement du formulaire d'abonnement
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Génération des tokens
            $validationToken = hash('sha256', uniqid());
            $unsubscribeToken = hash('sha256', uniqid()); // Token de désinscription

            if (!$validationToken || !$unsubscribeToken) {
                throw new \RuntimeException('Échec de la génération des tokens.');
            }

            $user->setValidationToken($validationToken);
            $user->setUnsubscribeToken($unsubscribeToken); // Ajout du token de désinscription
            $user->setValid(false);

            // Enregistrement de l'utilisateur en base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Envoi de l'e-mail de confirmation pour l'inscription
            $email = (new TemplatedEmail())
                ->from('newsletter@diossotourisme.fr')
                ->to($user->getEmail())
                ->subject('Confirmez votre inscription à notre newsletter')
                ->htmlTemplate('emails/registration.html.twig')
                ->context([
                    'user' => $user,
                    'validationToken' => $validationToken,
                ]);

            $mailer->send($email);

            // Envoi de l'email de désinscription avec le unsubscribeToken
            $emailUnsubscribe = (new TemplatedEmail())
                ->from('newsletter@diossotourisme.fr')
                ->to($user->getEmail())
                ->subject('Confirmez votre désinscription')
                ->htmlTemplate('emails/unsubscribe.html.twig')
                ->context([
                    'user' => $user,
                    'unsubscribeToken' => $unsubscribeToken,  // Utilisez bien 'unsubscribeToken'
                ]);

            $mailer->send($emailUnsubscribe); // Envoi du mail de désinscription

            $this->addFlash('success', 'Un e-mail de confirmation vous a été envoyé. Veuillez vérifier votre boîte mail.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/newsletter/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/confirm/{id}/{token}', name: 'app_confirm')]
    public function confirm(Users $user = null, $token): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        if ($user->getValidationToken() !== $token) {
            throw $this->createNotFoundException('Le lien de confirmation est invalide ou expiré.');
        }

        // Validation de l'utilisateur
        $user->setValid(true);
        $user->setValidationToken(null); // Invalide le token après utilisation
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre abonnement a été confirmé. Bienvenue dans notre communauté !');

        return $this->redirectToRoute('app_home');
    }

    #[Route('newsletter/prepareNewsletter', name: 'app_prepareNewsletter')]
    public function prepareNewsletter(Request $request): Response
    {
        $newsletter = new Newsletters();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($newsletter);
            $this->entityManager->flush();

            // Redirection après la soumission
            return $this->redirectToRoute('newsletterList');
        }

        return $this->render('/pages/newsletter/prepareNewsletter.html.twig', [
            'form' => $form->createView(),
        ]);
    }





    #[Route('/unsubscribe/{id}/{token}', name: 'app_unsubscribe')]
    public function unsubscribe(Users $user = null, $token): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Vérification du token de désinscription
        if ($user->getUnsubscribeToken() !== $token) {
            throw $this->createNotFoundException('Le lien de désinscription est invalide ou expiré.');
        }

        // Désinscription de l'utilisateur
        $user->setValid(false);  // Marquer l'utilisateur comme désinscrit
        $user->setUnsubscribeToken(null); // Invalide le token de désinscription
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre désinscription a été confirmée.');

        return $this->redirectToRoute('app_home');
    }
}


