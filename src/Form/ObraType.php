<?php

namespace App\Form;

use App\Entity\Arxiu;
use App\Entity\Client;
use App\Entity\Obra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType; // Mantenemos VichFileType

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
            ->add('portadaFile', VichFileType::class, [ // Mantenemos VichFileType
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
            ->add('url_arxiu', EntityType::class, [
                'class' => Arxiu::class,
                'choice_label' => 'nom_original',
                'label' => 'Archivo PDF asociado',
                'attr' => ['class' => 'form-select'],
                'placeholder' => 'Selecciona un archivo PDF existente',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Obra::class,
        ]);
    }
}
