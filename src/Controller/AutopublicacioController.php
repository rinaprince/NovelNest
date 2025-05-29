<?php

namespace App\Controller;

use App\Entity\Arxiu;
use App\Entity\Obra;
use App\Entity\Client;
use App\Repository\ArxiuRepository;
use App\Repository\ObraRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AutopublicacioController extends AbstractController
{
    #[Route('/autopublicacio', name: 'app_autopublicacio')]
    public function index(
        Request $request,
        ArxiuRepository $arxiuRepository,
        ObraRepository $obraRepository,
        ClientRepository $clientRepository,
        SluggerInterface $slugger
    ): Response {
        // Verificar si el usuario tiene ROLE_CLIENT o ROLE_TREBALLADOR
        if (!$this->isGranted('ROLE_CLIENT') && !$this->isGranted('ROLE_TREBALLADOR')) {
            return $this->redirectToRoute('app_login');
        }

        $mensaje = null;

        if ($request->isMethod('POST')) {
            // Validar que se haya subido un archivo
            if (!$request->files->get('pdf')) {
                $mensaje = 'Debes seleccionar un archivo PDF.';
                return $this->render('autopublicacio/index.html.twig', [
                    'mensaje' => $mensaje,
                    'clients' => $clientRepository->findAll(),
                ]);
            }

            /** @var UploadedFile $pdfFile */
            $pdfFile = $request->files->get('pdf');
            $nomObra = $request->get('nom');

            // Validar tipo de archivo
            if ($pdfFile->getMimeType() !== 'application/pdf') {
                $mensaje = 'Solo se permiten archivos PDF.';
                return $this->render('autopublicacio/index.html.twig', [
                    'mensaje' => $mensaje,
                    'clients' => $clientRepository->findAll(),
                ]);
            }

            // Validar tamaño del archivo (ejemplo: máximo 10MB)
            if ($pdfFile->getSize() > 10000000) {
                $mensaje = 'El archivo es demasiado grande. Tamaño máximo: 10MB.';
                return $this->render('autopublicacio/index.html.twig', [
                    'mensaje' => $mensaje,
                    'clients' => $clientRepository->findAll(),
                ]);
            }

            try {
                // Directorio de almacenamiento
                $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/pdf';

                // Crear directorio si no existe
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Generar nombre único para el archivo
                $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $pdfFileName = $safeFilename.'-'.uniqid().'.'.$pdfFile->guessExtension();

                // Mover el archivo
                $pdfFile->move($uploadDir, $pdfFileName);

                // Guardar el archivo en la base de datos
                $arxiu = new Arxiu();
                $arxiu->setArxiuPdf($pdfFileName);
                $arxiu->setArxiuPortada('');
                $arxiuRepository->save($arxiu, true);

                // Determinar el cliente
                $client = $this->isGranted('ROLE_TREBALLADOR')
                    ? $clientRepository->find($request->get('client_id'))
                    : $this->getUser();

                if (!$client) {
                    $mensaje = 'Cliente no encontrado.';
                    return $this->render('autopublicacio/index.html.twig', [
                        'mensaje' => $mensaje,
                        'clients' => $clientRepository->findAll(),
                    ]);
                }

                // Crear la obra asociada
                $obra = new Obra();
                $obra->setNom($nomObra);
                $obra->setTipus('Novela');
                $obra->setEstat(false);
                $obra->setPortada('');
                $obra->setUrlArxiu($arxiu);
                $obra->setClient($client);

                // Factura asociada
                $factura = $client->getIdFactura();
                if ($factura) {
                    $obra->setFactura($factura);
                }

                $obraRepository->save($obra, true);

                $mensaje = 'Archivo PDF subido y obra creada exitosamente.';
            } catch (FileException $e) {
                $mensaje = 'Ocurrió un error al subir el archivo: ' . $e->getMessage();
            }
        }

        return $this->render('autopublicacio/index.html.twig', [
            'mensaje' => $mensaje,
            'clients' => $clientRepository->findAll(),
        ]);
    }
}