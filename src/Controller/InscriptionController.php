<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription', methods: ['GET', 'POST'])]
    public function register(
        Request $request, 
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $passwordHasher, 
        UserRepository $userRepository
    ): Response {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingUser = $userRepository->findOneBy(['email' => $user->getEmail()]);
            
            if ($existingUser) {
                $this->addFlash('error', 'Un utilisateur avec cet email existe déjà.');
                return $this->redirectToRoute('app_inscription');
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword);
            $user->generateUserInitial();

            $entityManager->persist($user);
            $entityManager->flush();

            // Ajouter un message flash de succès
            $this->addFlash('success', 'Inscription réussie !');

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('/pages/inscription/index.html.twig', [
            'inscriptionType' => $form->createView(),
        ]);
    }
}
