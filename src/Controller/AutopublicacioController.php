<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AutopublicacioController extends AbstractController
{
    #[Route('/autopublicacio', name: 'app_autopublicacio')]
    public function index(Request $request): Response
    {
        $mensaje = null;

        if ($request->isMethod('POST') && $request->files->get('pdf')) {
            if (!$this->isGranted('ROLE_CLIENT')) {
                return $this->redirectToRoute('app_login');
            }

            /** @var UploadedFile $pdfFile */
            $pdfFile = $request->files->get('pdf');

            if ($pdfFile->getClientOriginalExtension() !== 'pdf') {
                $mensaje = 'El archivo debe ser un PDF.';
            } else {
                try {
                    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
                    $pdfFileName = uniqid() . '.' . $pdfFile->guessExtension();
                    $pdfFile->move($uploadDir, $pdfFileName);
                    $mensaje = 'Archivo subido exitosamente.';
                } catch (FileException $e) {
                    $mensaje = 'Ocurrió un error al subir el archivo.';
                }
            }
        }

        return $this->render('autopublicacio/index.html.twig', [
            'mensaje' => $mensaje,
        ]);
    }
}
