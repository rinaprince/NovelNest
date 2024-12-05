<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Entity\Treballador;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarisController extends AbstractController
{
    #[Route('/admin/usuaris', name: 'app_usuaris_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $administradors = $em->getRepository(Administrador::class)->findAll();
        $treballadors = $em->getRepository(Treballador::class)->findAll();

        return $this->render('usuaris/index.html.twig', [
            'administradors' => $administradors,
            'treballadors' => $treballadors,
        ]);
    }

    #[Route('/admin/usuaris/new', name: 'app_usuaris_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $role = $request->query->get('role', 'admin');
        $user = $role === 'admin' ? new Administrador() : new Treballador();

        $form = $this->createForm(UserType::class, $user, [
            'data_class' => get_class($user),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Usuari creat correctament!');
            return $this->redirectToRoute('app_usuaris_index');
        }

        return $this->render('usuaris/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/usuaris/{id}/show', name: 'app_usuaris_show')]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $user = $em->find(User::class, $id);

        if (!$user || !($user instanceof Administrador || $user instanceof Treballador)) {
            throw $this->createNotFoundException('Usuari no trobat.');
        }

        return $this->render('usuaris/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/admin/usuaris/{id}/edit', name: 'app_usuaris_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $user = $em->find(User::class, $id);

        if (!$user || !($user instanceof Administrador || $user instanceof Treballador)) {
            throw $this->createNotFoundException('Usuari no trobat.');
        }

        $form = $this->createForm(UserType::class, $user, [
            'data_class' => get_class($user),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Usuari actualitzat correctament!');
            return $this->redirectToRoute('app_usuaris_index');
        }

        return $this->render('usuaris/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/usuaris/{id}/delete', name: 'app_usuaris_delete')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $user = $em->find(User::class, $id);

        if ($user && ($user instanceof Administrador || $user instanceof Treballador)) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Usuari eliminat correctament!');
        }

        return $this->redirectToRoute('app_usuaris_index');
    }
}