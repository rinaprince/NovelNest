<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContacteController extends AbstractController
{
    #[Route('/contacte', name: 'app_contacte')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class, [
                'label' => 'Nombre',
                'required' => true,
            ])
            ->add('cognom', TextType::class, [
                'label' => 'Apellido',
                'required' => true,
            ])
            ->add('correu', EmailType::class, [
                'label' => 'Correo Electrónico',
                'required' => true,
            ])
            ->add('comentaris', TextareaType::class, [
                'label' => 'Comentarios',
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enviar',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('success_route');
        }

        return $this->render('contacte/index.html.twig', [
            'controller_name' => 'ContacteController',
            'form' => $form,
        ]);
    }
}
