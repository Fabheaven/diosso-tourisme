<?php

namespace App\Controller;

use App\Entity\Newsletter\Users;
use App\Form\NewsletterUsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(): Response
    {
        $user = new Users();
        $form = $this->createForm(NewsletterUsersType::class, $user);

        return $this->render('pages/newsletter/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
