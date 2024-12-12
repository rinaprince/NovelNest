<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResumController extends AbstractController
{
    #[Route('/resum', name: 'app_resum')]
    public function index(): Response
    {
        return $this->render('resum/index.html.twig', [
            'controller_name' => 'ResumController',
        ]);
    }
}
