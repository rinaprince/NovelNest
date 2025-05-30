<?php

namespace App\Form;

use App\Entity\Arxiu;
use App\Entity\Client;
use App\Entity\Factura;
use App\Entity\Obra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\File;

class ObraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipus', ChoiceType::class, [
                'choices' => [
                    'Novela' => 'Novela',
                    'Relato corto' => 'Relato corto',
                    'Poesía' => 'Poesía',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('nom')
            ->add('numObra_seguiment')
            ->add('estat', ChoiceType::class, [
                'choices' => [
                    'Entregado' => true,
                    'No entregado' => false,
                ],
            ])
            ->add('portada', FileType::class, [
                'label' => 'Portada (Archivo)',
                'required' => false,
                'mapped' => false,
                'attr' => ['accept' => 'image/*']
            ])
            ->add('portadaFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'label' => 'Portada',
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Por favor, sube una imagen válida (JPEG, PNG o GIF).',
                    ])
                ]
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'pseudonim',
            ])
            ->add('url_arxiu', EntityType::class, [
                'class' => Arxiu::class,
                'choice_label' => 'nom_original',
                'label' => 'Archivo PDF',
            ])
            ->add('factura', EntityType::class, [
                'class' => Factura::class,
                'choice_label' => 'num_factura',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Obra::class,
        ]);
    }
}
