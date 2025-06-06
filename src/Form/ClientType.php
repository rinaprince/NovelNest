<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_usuari')
            ->add('contrasenya', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'mapped' => false,
            ])
            ->add('nom')
            ->add('cognom')
            ->add('correu')
            ->add('rols', ChoiceType::class, [
                'choices' => [
                    'Cliente' => 'ROLE_CLIENT',
                ],
                'multiple' => true,
                'expanded' => false,
                'label' => 'Roles',
            ])
            ->add('telef')
            ->add('direccio')
            ->add('num_tarj')
            ->add('pseudonim')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
