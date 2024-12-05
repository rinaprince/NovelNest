<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Factura;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_usuari')
            ->add('contrasenya')
            ->add('nom')
            ->add('cognom')
            ->add('correu')
            ->add('rols')
            ->add('telef')
            ->add('direccio')
            ->add('num_tarj')
            ->add('pseudonim')
            ->add('id_Factura', EntityType::class, [
                'class' => Factura::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
