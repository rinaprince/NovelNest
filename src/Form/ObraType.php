<?php

namespace App\Form;

use App\Entity\Arxiu;
use App\Entity\Client;
use App\Entity\Obra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Doctrine\ORM\EntityManagerInterface;

class ObraType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipus', ChoiceType::class, [
                'choices' => [
                    'Novela' => 'Novela',
                    'Relato corto' => 'Relato corto',
                    'Poesía' => 'Poesía',
                ],
                'label' => 'Tipo de obra',
                'attr' => ['class' => 'form-select']
            ])
            ->add('nom', null, [
                'label' => 'Nombre de la obra',
                'attr' => ['class' => 'form-control']
            ])
            ->add('numObra_seguiment', null, [
                'label' => 'Número de seguimiento',
                'attr' => ['class' => 'form-control']
            ])
            ->add('estat', ChoiceType::class, [
                'choices' => [
                    'Entregado' => true,
                    'No entregado' => false,
                ],
                'label' => 'Estado',
                'attr' => ['class' => 'form-select']
            ])
            ->add('portadaFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'label' => 'Portada (Imagen JPG/PNG)',
                'attr' => ['accept' => 'image/jpeg,image/png']
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'pseudonim',
                'label' => 'Cliente',
                'attr' => ['class' => 'form-select']
            ])
            ->add('nuevo_pdf', FileType::class, [
                'label' => 'Subir nuevo archivo PDF',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'application/pdf'],
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Por favor, sube un archivo PDF válido.',
                    ])
                ]
            ]);

        // Evento para asociar un nuevo archivo PDF subido
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var Obra $obra */
            $obra = $event->getData();
            $form = $event->getForm();

            $nuevoPdf = $form->get('nuevo_pdf')->getData();

            if ($nuevoPdf) {
                $arxiu = new Arxiu();
                $arxiu->setArxiuPdf($nuevoPdf);
                $arxiu->setNomOriginal($nuevoPdf->getClientOriginalName());
                $this->em->persist($arxiu);
                $this->em->flush();

                $obra->setUrlArxiu($arxiu);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Obra::class,
        ]);
    }
}
