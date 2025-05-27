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

class AutopublicacioController extends AbstractController
{
    #[Route('/autopublicacio', name: 'app_autopublicacio')]
    public function index(Request $request, ArxiuRepository $arxiuRepository, ObraRepository $obraRepository, ClientRepository $clientRepository): Response
    {
        $mensaje = null;

        // Validación de datos
        if ($request->isMethod('POST') && $request->files->get('pdf') && $request->get('nom') && $request->get('client_id')) {
            if (!$this->isGranted('ROLE_CLIENT') && !$this->isGranted('ROLE_TREBALLADOR')) {
                return $this->redirectToRoute('app_login');
            }

            /** @var UploadedFile $pdfFile */
            $pdfFile = $request->files->get('pdf');
            $nomObra = $request->get('nom');
            $clientId = $request->get('client_id');

            // Validación de extensión
            if ($pdfFile->getClientOriginalExtension() !== 'pdf') {
                $mensaje = 'El archivo debe ser un PDF.';
            } else {
                try {
                    // Directorio de almacenamiento
                    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
                    $pdfFileName = uniqid() . '.' . $pdfFile->guessExtension();
                    $pdfFile->move($uploadDir, $pdfFileName);

                    // Guardar el archivo en la base de datos
                    $arxiu = new Arxiu();
                    $arxiu->setArxiuPdf($pdfFileName);
                    $arxiu->setArxiuPortada('');
                    $arxiuRepository->save($arxiu, true);

                    // Buscar cliente
                    $client = $clientRepository->find($clientId);

                    if (!$client) {
                        $mensaje = 'Cliente no encontrado.';
                    } else {
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
                        } else {
                            $mensaje = 'Factura del cliente no encontrada.';
                            return $this->render('autopublicacio/index.html.twig', ['mensaje' => $mensaje]);
                        }

                        $obraRepository->getEntityManager()->persist($obra);
                        $obraRepository->getEntityManager()->flush();

                        $mensaje = 'Archivo subido y obra creada exitosamente.';
                    }
                } catch (FileException $e) {
                    $mensaje = 'Ocurrió un error al subir el archivo.';
                }
            }
        } else {
            $mensaje = '';
        }

        return $this->render('autopublicacio/index.html.twig', [
            'mensaje' => $mensaje,
            'clients' => $clientRepository->findAll(),
        ]);
    }
}
