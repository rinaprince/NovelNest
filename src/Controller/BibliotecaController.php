<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BibliotecaController extends AbstractController
{
    #[Route('/biblioteca', name: 'app_biblioteca')]
    public function index(): Response
    {
        return $this->render('biblioteca/index.html.twig', [
            'controller_name' => 'BibliotecaController',
        ]);
    }
}
