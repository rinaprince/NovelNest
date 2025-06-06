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

        if (empty($q)) {
            $queryBuilder = $obraRepository->createQueryBuilder('o')
                ->andWhere('o.estat = :estat')
                ->setParameter('estat', true)
                ->orderBy('o.id', 'ASC');
            $query = $queryBuilder->getQuery();
        } else {
            $query = $obraRepository->findByTextQuery($q);
            $dql = $query->getDQL() . ' AND o.estat = :estat';
            $query = $obraRepository->getEntityManager()
                ->createQuery($dql)
                ->setParameter('val', "%$q%")
                ->setParameter('estat', true);
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('biblioteca/index.html.twig', [
            'q' => $q,
            'pagination' => $pagination,
            'obres' => $pagination->getItems(),
        ]);
    }
}
