<?php

namespace App\Form;

use App\Entity\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContainerModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('volume')
            ->add('poidsBrut')
            ->add('chargeUtile')
            ->add('archive')
            ->add('habitation')
            ->add('typeDechet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Container::class,
        ]);
    }
}
