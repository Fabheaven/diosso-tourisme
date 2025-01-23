<?php

namespace App\Controller;

use App\Entity\Newsletter\Users;
use App\Form\NewsletterUsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(NewsletterUsersType::class, $user);

        // Traitement du formulaire d'abonnement
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setValidationToken($token);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre abonnement est en attente de validation');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/newsletter/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
