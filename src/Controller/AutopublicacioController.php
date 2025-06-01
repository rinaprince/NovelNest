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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AutopublicacioController extends AbstractController
{
    #[Route('/autopublicacio', name: 'app_autopublicacio')]
    public function index(
        Request $request,
        ArxiuRepository $arxiuRepository,
        ObraRepository $obraRepository,
        ClientRepository $clientRepository,
        SluggerInterface $slugger,
        ValidatorInterface $validator
    ): Response {
        $mensaje = null;
        $formErrors = [];
        $showForm = $this->isGranted('ROLE_CLIENT') || $this->isGranted('ROLE_TREBALLADOR');
        $accessDenied = !$showForm && $request->isMethod('POST');

        if ($request->isMethod('POST') && $showForm) {
            $pdfFile = $request->files->get('pdf');
            $nomObra = $request->get('nom');
            $clientId = $this->isGranted('ROLE_TREBALLADOR') ? $request->get('client_id') : $this->getUser()->getId();

            // Validaciones
            if (!$pdfFile) {
                $formErrors['pdf'] = 'Debes seleccionar un archivo PDF.';
            } elseif ($pdfFile->getClientMimeType() !== 'application/pdf') {
                $formErrors['pdf'] = 'Solo se permiten archivos PDF.';
            } elseif ($pdfFile->getSize() > 10000000) {
                $formErrors['pdf'] = 'El archivo es demasiado grande. Tamaño máximo: 10MB.';
            }

            if (empty($nomObra)) {
                $formErrors['nom'] = 'El título es obligatorio.';
            }

            if ($this->isGranted('ROLE_TREBALLADOR') && empty($clientId)) {
                $formErrors['client_id'] = 'Debes seleccionar un cliente.';
            }

            if (empty($formErrors)) {
                try {
                    $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads/pdf';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $pdfFileName = $safeFilename.'-'.uniqid().'.'.$pdfFile->guessExtension();

                    $pdfFile->move($uploadDir, $pdfFileName);

                    // Crear nuevo Arxiu
                    $arxiu = new Arxiu();
                    $arxiu->setArxiuPdf($pdfFileName);
                    $arxiu->setArxiuPortada('');
                    $arxiu->setNomOriginal($pdfFile->getClientOriginalName()); // Guardar nombre original

                    $errors = $validator->validate($arxiu);
                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            $formErrors[$error->getPropertyPath()] = $error->getMessage();
                        }
                    } else {
                        $arxiuRepository->save($arxiu, true);
                        $client = $clientRepository->find($clientId);

                        if ($client) {
                            $obra = new Obra();
                            $obra->setNom($nomObra);
                            $obra->setTipus('Novela');
                            $obra->setEstat(false);
                            $obra->setPortada('');
                            $obra->setUrlArxiu($arxiu);
                            $obra->setClient($client);

                            if ($client->getIdFactura()) {
                                $obra->setFactura($client->getIdFactura());
                            }

                            $obraRepository->save($obra, true);
                            $mensaje = 'Archivo PDF subido y obra creada exitosamente.';
                        } else {
                            $formErrors['client_id'] = 'Cliente no encontrado.';
                        }
                    }
                } catch (FileException $e) {
                    $formErrors['pdf'] = 'Error al subir el archivo: '.$e->getMessage();
                }
            }
        }

        return $this->render('autopublicacio/index.html.twig', [
            'mensaje' => $mensaje,
            'formErrors' => $formErrors,
            'showForm' => $showForm,
            'accessDenied' => $accessDenied,
            'clients' => $this->isGranted('ROLE_TREBALLADOR') ? $clientRepository->findAll() : [],
            'submittedData' => $accessDenied ? $request->request->all() : null,
        ]);
    }
}