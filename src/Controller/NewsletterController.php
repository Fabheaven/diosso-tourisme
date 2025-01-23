<?php

namespace App\Controller;

use App\Entity\Newsletter\Users;
use App\Form\NewsletterUsersType;
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
            // Génération d'un token unique
            $token = hash('sha256', uniqid());
            if (!$token) {      
                throw new \RuntimeException('Échec de la génération du token.');
            }

            $user->setValidationToken($token);
            $user->setValid(false);

            // Enregistrement de l'utilisateur en base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Envoi de l'e-mail de confirmation
            $email = (new TemplatedEmail())
                ->from('newsletter@diossotourisme.fr')
                ->to($user->getEmail())
                ->subject('Confirmez votre inscription à notre newsletter')
                ->htmlTemplate('emails/registration.html.twig')
                ->context([
                    'user' => $user,
                    'token' => $token,
                ]);

            $mailer->send($email);

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
}
