<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditorsController extends AbstractController
{
    #[Route('/editors', name: 'app_editors')]
    public function index(): Response
    {
        return $this->render('editors/index.html.twig', [
            'controller_name' => 'EditorsController',
        ]);
    }
}
