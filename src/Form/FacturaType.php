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
            ->add('num_factura')
            ->add('preu')
            ->add('quantitat')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'label' => 'client',
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('obres', EntityType::class, [
                'class' => Obra::class,
                'label' => 'Obra',
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control'],
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }
}
