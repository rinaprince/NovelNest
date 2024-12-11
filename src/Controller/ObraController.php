<?php

namespace App\Controller;

use App\Entity\Obra;
use App\Form\ObraType;
use App\Repository\ObraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/obra')]
final class ObraController extends AbstractController
{
    #[Route(name: 'app_obra_index', methods: ['GET'])]
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

        return $this->render('obra/index.html.twig', [
            'q' => $q,
            'pagination' => $pagination,
            'obras' => $pagination->getItems(),
        ]);
    }

    #[Route('/new', name: 'app_obra_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $obra = new Obra();
        $form = $this->createForm(ObraType::class, $obra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($obra);
            $entityManager->flush();

            return $this->redirectToRoute('app_obra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('obra/new.html.twig', [
            'obra' => $obra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_obra_show', methods: ['GET'])]
    public function show(Obra $obra): Response
    {
        return $this->render('obra/show.html.twig', [
            'obra' => $obra,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_obra_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Obra $obra, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ObraType::class, $obra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_obra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('obra/edit.html.twig', [
            'obra' => $obra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_obra_delete', methods: ['POST'])]
    public function delete(Request $request, Obra $obra, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$obra->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($obra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_obra_index', [], Response::HTTP_SEE_OTHER);
    }
}
