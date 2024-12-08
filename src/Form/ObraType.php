<?php

namespace App\Form;

use App\Entity\Arxiu;
use App\Entity\Client;
use App\Entity\Factura;
use App\Entity\Obra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipus')
            ->add('nom')
            ->add('numObra_seguiment')
            ->add('estat')
            ->add('portada')
            ->add('pseudonim_client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
            ])
            ->add('url_arxiu', EntityType::class, [
                'class' => Arxiu::class,
                'choice_label' => 'id',
            ])
            ->add('factura', EntityType::class, [
                'class' => Factura::class,
                'choice_label' => 'id',
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
