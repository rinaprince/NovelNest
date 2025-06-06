<?php

namespace App\Controller;

use App\Entity\Arxiu;
use App\Entity\Carrito;
use App\Entity\Obra;
use App\Entity\Client;
use App\Repository\ArxiuRepository;
use App\Repository\CarritoRepository;
use App\Repository\ObraRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class AutopublicacioController extends AbstractController
{
    #[Route('/autopublicacio', name: 'app_autopublicacio')]
    public function index(
        Request                $request,
        ArxiuRepository        $arxiuRepository,
        ObraRepository         $obraRepository,
        ClientRepository       $clientRepository,
        EntityManagerInterface $entityManager,
        SluggerInterface       $slugger,
        ValidatorInterface     $validator
    ): Response {
        $formErrors = [];
        $submittedData = [];
        $showForm = $this->isGranted('ROLE_CLIENT') || $this->isGranted('ROLE_TREBALLADOR');

        if ($request->isMethod('POST')) {
            $submittedData = $request->request->all();

            $pdfFile = $request->files->get('pdf');
            $nomObra = $request->request->get('nom');
            $paginas = (int)$request->request->get('paginas', 1);
            $clientId = $this->isGranted('ROLE_TREBALLADOR') ? $request->request->get('client_id') : $this->getUser()?->getId();

            // Validaciones
            if (!$pdfFile) {
                $formErrors['pdf'] = 'Debes seleccionar un archivo PDF.';
            } elseif (!in_array($pdfFile->getClientMimeType(), ['application/pdf', 'application/x-pdf'])) {
                $formErrors['pdf'] = 'Solo se permiten archivos PDF.';
            } elseif ($pdfFile->getSize() > 10000000) {
                $formErrors['pdf'] = 'El archivo es demasiado grande. Tamaño máximo: 10MB.';
            }

            if (empty(trim($nomObra))) {
                $formErrors['nom'] = 'El título es obligatorio.';
            } elseif (strlen(trim($nomObra)) > 255) {
                $formErrors['nom'] = 'El título no puede exceder los 255 caracteres.';
            }

            if ($paginas < 1) {
                $formErrors['paginas'] = 'El número de páginas debe ser al menos 1.';
            }

            if ($this->isGranted('ROLE_TREBALLADOR') && empty($clientId)) {
                $formErrors['client_id'] = 'Debes seleccionar un cliente.';
            }

            if (!$showForm) {
                $this->addFlash('error', 'No tienes permisos para subir archivos.');
            } elseif (empty($formErrors)) {
                try {
                    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/pdf';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $pdfFileName = $safeFilename . '-' . uniqid() . '.' . $pdfFile->guessExtension();
                    $pdfFile->move($uploadDir, $pdfFileName);

                    $preu = $paginas * 0.05;

                    $arxiu = new Arxiu();
                    $arxiu->setArxiuPdf($pdfFileName);
                    $arxiu->setArxiuPortada('');
                    $arxiu->setNomOriginal($pdfFile->getClientOriginalName());
                    $arxiu->setPaginas($paginas);

                    $errors = $validator->validate($arxiu);
                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            $formErrors[$error->getPropertyPath()] = $error->getMessage();
                        }
                        throw new \RuntimeException('Error de validación del archivo');
                    }

                    $arxiuRepository->save($arxiu, true);

                    $client = $clientRepository->find($clientId);
                    if (!$client) {
                        throw $this->createNotFoundException('Cliente no encontrado');
                    }

                    $obra = new Obra();
                    $obra->setNom(trim($nomObra));
                    $obra->setTipus('Novela');
                    $obra->setEstat(false);
                    $obra->setPortada('');
                    $obra->setUrlArxiu($arxiu);
                    $obra->setClient($client);
                    $obra->setNumObraSeguiment(rand(1000, 9999));
                    $obra->setPreu($preu);

                    $errors = $validator->validate($obra);
                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            $formErrors[$error->getPropertyPath()] = $error->getMessage();
                        }
                        throw new \RuntimeException('Error de validación de la obra');
                    }

                    $obraRepository->save($obra, true);

                    $carrito = new Carrito();
                    $carrito->setUsuariCompra($client->getNom() . ' ' . $client->getCognom());
                    $carrito->setObra($obra);
                    $carrito->setDataCreacio(new \DateTime());
                    $carrito->setQuantitat(1);
                    $carrito->setPreu($preu);

                    $entityManager->persist($carrito);
                    $entityManager->flush();

                    $this->addFlash('success', 'Archivo PDF subido y obra creada exitosamente. Se ha añadido al carrito.');
                    return $this->redirectToRoute('app_autopublicacio');
                } catch (FileException $e) {
                    $formErrors['pdf'] = 'Error al subir el archivo: ' . $e->getMessage();
                    $this->addFlash('error', 'Error al procesar el archivo PDF.');
                } catch (\Exception $e) {
                    $formErrors['general'] = 'Se produjo un error inesperado.';
                    $this->addFlash('error', 'Error al procesar tu solicitud.');
                }
            } else {
                $this->addFlash('error', 'Por favor, corrige los errores en el formulario.');
            }
        }

        return $this->render('autopublicacio/index.html.twig', [
            'formErrors' => $formErrors,
            'showForm' => $showForm,
            'clients' => $this->isGranted('ROLE_TREBALLADOR') ? $clientRepository->findAll() : [],
            'submittedData' => $submittedData,
        ]);
    }
}