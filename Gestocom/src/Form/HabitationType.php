<?php

namespace App\Form;

use App\Entity\Habitation;
use App\Entity\Usager;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HabitationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('adresse')
            ->add('copos')
            ->add('ville')
            ->add('usager',EntityType::class,array(
                'class' => Usager::class,
                'choice_label'=>'mail'
  
              ))
            ->add('archiver', TextType::class);  

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Habitation::class,
        ]);

    }
    
}
