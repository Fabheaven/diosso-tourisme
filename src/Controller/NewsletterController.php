<?php

namespace App\Controller;

use App\Entity\Newsletters\Newsletters;
use App\Entity\Newsletters\Users;
use App\Form\NewslettersUsersType;
use App\Form\NewsletterType;
use App\Repository\Newsletters\NewslettersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(NewslettersUsersType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setValidationToken($token);

            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('newsletter@diossotourisme.fr')
                ->to($user->getEmail())
                ->subject('Votre inscription à la newsletter')
                ->htmlTemplate('emails/newsletterSign.html.twig')
                ->context([
                    'user' => $user,
                    'token' => $token,
                    'confirmation_url' => $this->generateUrl('app_confirm', ['id' => $user->getId(), 'token' => $token], 1)
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre inscription est en attente de validation. Un email de confirmation vous a été envoyé.');

            return $this->redirectToRoute('app_newsletter_confirm');
        }

        return $this->render('pages/newsletter/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/confirm/{id}/{token}', name: 'app_confirm')]
    public function confirm(Users $user, string $token, EntityManagerInterface $entityManager): Response
    {
        if ($user->getValidationToken() !== $token) {
            throw $this->createNotFoundException('Le token est invalide');
        }

        $user->setValid(true);
        $user->setValidationToken(null);

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte a été activé avec succès.');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/newsletter/confirmation', name: 'app_newsletter_confirm')]
    public function confirmPage(): Response
    {
        return $this->render('pages/newsletter/confirm.html.twig');
    }

    #[Route('/newsletter/editNewsletter', name: 'app_newsletter_editNewsletter')]
    public function editNewsletter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newsletter = new Newsletters();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newsletter);
            $entityManager->flush();

            return $this->redirectToRoute('app_newsletter_list');
        }

        return $this->render('pages/newsletter/editNewsletter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/newsletter/list', name: 'app_newsletter_list')]
    public function list(NewslettersRepository $newsletter): Response
    {
        return $this->render('pages/newsletter/list.html.twig', [
            'newsletters' => $newsletter->findAll()
        ]);
    }
}




