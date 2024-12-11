<?php

namespace App\Controller;

use App\Repository\ObraRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BibliotecaController extends AbstractController
{
    #[Route('/biblioteca', name: 'app_biblioteca', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, ObraRepository $obraRepository): Response
    {
        /* Paginador i cercador */
        $q = $request->query->get('q', '');

        if (empty($q))
            $query = $obraRepository->findAllQuery();
        else
            $query = $obraRepository->findByTextQuery($q);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('biblioteca/index.html.twig', [
            'q' => $q,
            'pagination' => $pagination,
            'obres' => $pagination->getItems(),
        ]);
    }
}
