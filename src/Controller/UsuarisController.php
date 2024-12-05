<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Entity\Treballador;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarisController extends AbstractController
{
    #[Route('/admin/usuaris', name: 'app_usuaris_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        //Obtindre administradors/treballadors
        $administradors = $userRepository->findBy(['rol' => 'admin']);
        $treballadors = $userRepository->findBy(['rol' => 'treballador']);

        //Combinar resultats
        $usuaris = array_merge($administradors, $treballadors);

        return $this->render('usuaris/index.html.twig', [
            'usuaris' => $usuaris,
        ]);
    }

    #[Route('admin/usuaris/nou', name: 'app_usuaris_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->request->all();
            $userClass = $data['rol'] === 'admin' ? Administrador::class : Treballador::class;

            $usuari = new $userClass();
            $usuari->setNom($data['nom'])
                ->setCognom($data['cognom'])
                ->setNomUsuari($data['nom_usuari'])
                ->setContrasenya(password_hash($data['contrasenya'], PASSWORD_BCRYPT))
                ->setRols([$data['rol']]);

            $userRepository->save($usuari, true);

            return $this->redirectToRoute('app_usuaris_index');
        }

        return $this->render('usuaris/new.html.twig');
    }

    #[Route('admin/usuaris/{id}/editar', name: 'app_usuaris_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, int $id): Response
    {
        $usuari = $userRepository->find($id);

        if (!$usuari) {
            throw $this->createNotFoundException('Usuari no trobat');
        }

        if ($request->getMethod() === 'POST') {
            $data = $request->request->all();
            $usuari->setNom($data['nom'])
                ->setCognom($data['cognom'])
                ->setNomUsuari($data['nom_usuari']);

            $userRepository->save($usuari, true);

            return $this->redirectToRoute('app_usuaris_index');
        }

        return $this->render('usuaris/edit.html.twig', [
            'usuari' => $usuari,
        ]);
    }

    #[Route('admin/usuaris/{id}/eliminar', name: 'app_usuaris_delete', methods: ['POST'])]
    public function delete(Request $request, UserRepository $userRepository, int $id): Response
    {
        $usuari = $userRepository->find($id);

        if (!$usuari) {
            throw $this->createNotFoundException('Usuari no trobat');
        }

        $userRepository->remove($usuari, true);

        return $this->redirectToRoute('app_usuaris_index');
    }
}
