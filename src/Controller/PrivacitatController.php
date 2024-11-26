<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrivacitatController extends AbstractController
{
    #[Route('/privacitat', name: 'app_privacitat')]
    public function index(): Response
    {
        return $this->render('privacitat/index.html.twig', [
            'controller_name' => 'PrivacitatController',
        ]);
    }
}
