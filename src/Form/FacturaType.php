<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Factura;
use App\Entity\Obra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipus')
            ->add('nom', EntityType::class, [
                'class' => Obra::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
                'mapped' => false,
                'placeholder' => 'Selecciona una obra',
            ])
            ->add('num_factura')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'nom_usuari',
                'placeholder' => 'Selecciona un cliente',
            ])
            ->add('cognom', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'cognom',
                'mapped' => false,
                'placeholder' => 'Selecciona un apellido',
            ])
            ->add('correu', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'correu',
                'mapped' => false,
                'placeholder' => 'Selecciona un correo',
            ])
            ->add('preu')
            ->add('quantitat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }
}
