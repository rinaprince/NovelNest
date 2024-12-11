<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistreController extends AbstractController
{
    #[Route('/registre', name: 'app_registre')]
    public function index(): Response
    {
        return $this->render('registre/index.html.twig', [
            'controller_name' => 'RegistreController',
        ]);
    }
}
