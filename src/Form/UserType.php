<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_usuari')
            ->add('contrasenya', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'mapped' => false,
            ])
            ->add('nom')
            ->add('cognom')
            ->add('correu')
            ->add('rols', ChoiceType::class, [
                'choices' => [
                    'Administrador' => 'ROLE_ADMIN',
                    'Treballador' => 'ROLE_TREBALLADOR',
                ],
                'multiple' => true,
                'expanded' => false,
                'label' => 'Roles',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
