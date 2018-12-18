<?php

namespace App\Form;

use App\Entity\Container;
use App\Entity\Habitation;
use App\Entity\TypeDechet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ContainerHabitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeDechet', EntityType::class, array('class' => 'App\Entity\TypeDechet', 'choice_label' => 'libelle'))
            ->add('volume',NumberType::class, array('scale' => 3))
            ->add('poidsBrut',NumberType::class, array('scale' => 3))
            ->add('chargeUtile',NumberType::class, array('scale' => 3))
			->add('enregistrer', SubmitType::class, array('label' => 'Nouveau conteneur'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Container::class,
        ]);
    }
}
