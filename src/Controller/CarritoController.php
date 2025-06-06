<?php

namespace App\Controller;

use App\Entity\Carrito;
use App\Repository\CarritoRepository;
use App\Repository\ObraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarritoController extends AbstractController
{
    #[Route('/carrito', name: 'app_carrito')]
    public function index(Request $request, CarritoRepository $carritoRepository): Response
    {
        $user = $this->getUser();
        $session = $request->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $userIdentifier = $user
            ? $user->getNom() . ' ' . $user->getCognom()
            : 'anonimo_' . $session->getId();

        $carritoItems = $carritoRepository->findBy(['usuariCompra' => $userIdentifier]);

        $itemsWithDetails = [];
        $total = 0;

        foreach ($carritoItems as $item) {
            $obra = $item->getObra();
            if ($obra) {
                $itemsWithDetails[] = [
                    'id' => $item->getId(),
                    'carrito_id' => $item->getId(),
                    'obra' => $obra,
                    'cantidad' => $item->getQuantitat(),
                    'precio' => $item->getPreu(),
                    'paginas' => $obra->getUrlArxiu()?->getPaginas(),
                    'usuario' => $obra->getClient()?->getNom() . ' ' . $obra->getClient()?->getCognom()
                ];
                $total += $item->getPreu() * $item->getQuantitat();
            }
        }

        return $this->render('carrito/index.html.twig', [
            'items' => $itemsWithDetails,
            'total' => $total,
            'isClient' => $user && $this->isGranted('ROLE_CLIENT'),
        ]);
    }

    #[Route('/carrito/add/{id}', name: 'app_carrito_add')]
    public function addFromBiblioteca(
        int $id,
        ObraRepository $obraRepository,
        CarritoRepository $carritoRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $obra = $obraRepository->find($id);
        if (!$obra) {
            $this->addFlash('error', 'Obra no encontrada.');
            return $this->redirectToRoute('app_biblioteca');
        }

        $user = $this->getUser();
        $session = $request->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $userIdentifier = $user
            ? $user->getNom() . ' ' . $user->getCognom()
            : 'anonimo_' . $session->getId();

        $existingItem = $carritoRepository->findOneBy([
            'obra' => $obra,
            'usuariCompra' => $userIdentifier,
        ]);

        if ($existingItem) {
            $existingItem->setQuantitat($existingItem->getQuantitat() + 1);
        } else {
            $carritoItem = new Carrito();
            $carritoItem->setObra($obra);
            $carritoItem->setUsuariCompra($userIdentifier);
            $carritoItem->setQuantitat(1);
            $carritoItem->setDataCreacio(new \DateTime());
            $carritoItem->setPreu(15.0);
            $entityManager->persist($carritoItem);
        }

        $entityManager->flush();
        $this->addFlash('success', 'Obra añadida al carrito.');
        return $this->redirectToRoute('app_biblioteca');
    }

    #[Route('/carrito/remove/{id}', name: 'app_carrito_remove')]
    public function remove(
        int $id,
        CarritoRepository $carritoRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $item = $carritoRepository->find($id);
        if (!$item) {
            throw $this->createNotFoundException('El item no existe en el carrito');
        }

        $user = $this->getUser();
        $session = $request->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $userIdentifier = $user
            ? $user->getNom() . ' ' . $user->getCognom()
            : 'anonimo_' . $session->getId();

        if ($item->getUsuariCompra() !== $userIdentifier) {
            throw $this->createAccessDeniedException('No tienes permiso para modificar este item');
        }

        $entityManager->remove($item);
        $entityManager->flush();

        $this->addFlash('success', 'La obra ha sido eliminada del carrito');
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/update/{id}', name: 'app_carrito_update')]
    public function update(
        int $id,
        Request $request,
        CarritoRepository $carritoRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $item = $carritoRepository->find($id);
        if (!$item) {
            throw $this->createNotFoundException('El item no existe en el carrito');
        }

        $user = $this->getUser();
        $session = $request->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $userIdentifier = $user
            ? $user->getNom() . ' ' . $user->getCognom()
            : 'anonimo_' . $session->getId();

        if ($item->getUsuariCompra() !== $userIdentifier) {
            throw $this->createAccessDeniedException('No tienes permiso para modificar este item');
        }

        $cantidad = max((int) $request->request->get('cantidad', 1), 1);
        $item->setQuantitat($cantidad);

        $entityManager->flush();

        $this->addFlash('success', 'Cantidad actualizada');
        return $this->redirectToRoute('app_carrito');
    }
}
