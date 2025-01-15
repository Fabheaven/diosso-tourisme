<?php

namespace App\Controller;

use App\Form\ConnexionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'app_connexion', methods: ['GET', 'POST'])]
    public function connexion(Request $request): Response
    {
        // Créez une instance du formulaire ConnexionType
        $form = $this->createForm(ConnexionType::class);

        // Traitez la requête
        $form->handleRequest($request);

        // Logique supplémentaire si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Ajoutez votre logique ici (exemple : authentification)
            $this->addFlash('success', 'Connexion réussie !');
        }

        // Renvoyez la vue avec la variable contenant le formulaire
        return $this->render('/pages/connexion/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
