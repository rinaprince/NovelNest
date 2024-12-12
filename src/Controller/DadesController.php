<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DadesController extends AbstractController
{
    #[Route('/dades', name: 'app_dades')]
    public function index(): Response
    {
        return $this->render('dades/index.html.twig', [
            'controller_name' => 'DadesController',
        ]);
    }
}
