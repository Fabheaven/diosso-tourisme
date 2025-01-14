<?php

// src/Controller/FlightController.php

namespace App\Controller;

use App\Service\OpenSkyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlightController extends AbstractController
{
    private $openSkyService;

    public function __construct(OpenSkyService $openSkyService)
    {
        $this->openSkyService = $openSkyService;
    }

    /**
     * @Route("/flights/{airport}/departures", name="flights_departures")
     */
    public function departures(Request $request, string $airport): Response
    {
        // Paramètres de date
        $begin = strtotime('-1 hour'); // 1 heure en arrière
        $end = time(); // Heure actuelle

        $flights = $this->openSkyService->getDepartures($airport, $begin, $end);

        return $this->render('flights/departures.html.twig', [
            'flights' => $flights,
            'airport' => $airport,
        ]);
    }

    /**
     * @Route("/flights/{airport}/arrivals", name="flights_arrivals")
     */
    public function arrivals(Request $request, string $airport): Response
    {
        // Paramètres de date
        $begin = strtotime('-1 hour'); // 1 heure en arrière
        $end = time(); // Heure actuelle

        $flights = $this->openSkyService->getArrivals($airport, $begin, $end);

        return $this->render('flights/arrivals.html.twig', [
            'flights' => $flights,
            'airport' => $airport,
        ]);
    }
}

