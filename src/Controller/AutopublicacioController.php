<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AutopublicacioController extends AbstractController
{
    #[Route('/autopublicacio', name: 'app_autopublicacio')]
    public function index(): Response
    {
        return $this->render('autopublicacio/index.html.twig', [
            'controller_name' => 'AutopublicacioController',
        ]);
    }
}
