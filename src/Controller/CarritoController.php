<?php

namespace App\Controller;

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
    public function index(CarritoRepository $carritoRepository, ObraRepository $obraRepository): Response
    {
        $user = $this->getUser();
        $itemsWithDetails = [];
        $total = 0;
        $isClient = $this->isGranted('ROLE_CLIENT');

        if (!$isClient) {
            $this->addFlash('error', 'Debes ser cliente para acceder al carrito.');
            return $this->render('carrito/index.html.twig', [
                'items' => [],
                'total' => 0,
                'isClient' => false,
            ]);
        }

        // Buscar por nombre + apellido del usuario actual
        $userIdentifier = $user->getNom() . ' ' . $user->getCognom();
        $carritoItems = $carritoRepository->findBy(['usuariCompra' => $userIdentifier]);

        foreach ($carritoItems as $item) {
            $obra = $obraRepository->findOneBy(['nom' => $item->getObra()]);
            if ($obra) {
                $itemsWithDetails[] = [
                    'id' => $item->getId(),
                    'carrito_id' => $item->getId(),
                    'obra' => $obra,
                    'cantidad' => $item->getQuantitat(),
                    'precio' => $item->getPreu(),
                    'paginas' => $obra->getUrlArxiu()->getPaginas(),
                    'usuario' => $obra->getClient()->getNom() . ' ' . $obra->getClient()->getCognom()
                ];
                $total += $item->getPreu() * $item->getQuantitat();
            }
        }

        return $this->render('carrito/index.html.twig', [
            'items' => $itemsWithDetails,
            'total' => $total,
            'isClient' => true,
        ]);
    }

    #[Route('/carrito/remove/{id}', name: 'app_carrito_remove')]
    public function remove(int $id, CarritoRepository $carritoRepository, EntityManagerInterface $entityManager): Response
    {
        $item = $carritoRepository->find($id);

        if (!$item) {
            throw $this->createNotFoundException('El item no existe en el carrito');
        }

        // Verificar que el item pertenece al usuario actual
        $user = $this->getUser();
        $userIdentifier = $user->getNom() . ' ' . $user->getCognom();

        if ($item->getUsuariCompra() !== $userIdentifier) {
            throw $this->createAccessDeniedException('No tienes permiso para eliminar este item');
        }

        $entityManager->remove($item);
        $entityManager->flush();

        $this->addFlash('success', 'La obra ha sido eliminada del carrito');
        return $this->redirectToRoute('app_carrito');
    }

    #[Route('/carrito/update/{id}', name: 'app_carrito_update')]
    public function update(int $id, Request $request, CarritoRepository $carritoRepository, EntityManagerInterface $entityManager): Response
    {
        $item = $carritoRepository->find($id);

        if (!$item) {
            throw $this->createNotFoundException('El item no existe en el carrito');
        }

        // Verificar que el item pertenece al usuario actual
        $user = $this->getUser();
        $userIdentifier = $user->getNom() . ' ' . $user->getCognom();

        if ($item->getUsuariCompra() !== $userIdentifier) {
            throw $this->createAccessDeniedException('No tienes permiso para modificar este item');
        }

        $cantidad = (int)$request->request->get('cantidad', 1);
        if ($cantidad < 1) {
            $cantidad = 1;
        }

        $item->setQuantitat($cantidad);
        $entityManager->flush();

        $this->addFlash('success', 'Cantidad actualizada');
        return $this->redirectToRoute('app_carrito');
    }
}
