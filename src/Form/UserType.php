<?php

namespace App\Form;

use App\Entity\Administrador;
use App\Entity\Treballador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('cognom', TextType::class, [
                'label' => 'Cognom',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nom_usuari', TextType::class, [
                'label' => 'Nom d\'Usuari',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('contrasenya', PasswordType::class, [
                'label' => 'Contrasenya',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('rols', ChoiceType::class, [
                'label' => 'Rol',
                'choices' => [
                    'Administrador' => 'admin',
                    'Treballador' => 'treballador',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
