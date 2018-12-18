<?php

namespace App\Form;

use App\Entity\Usager;
use App\Entity\Utilisateur;
use App\Entity\Compte;

use App\Form\CompteType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UsagerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaiss', DateTimeType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',
                                                          'format' => 'dd/MM/yyyy',
                                                          'required' => true,
                                                          'label' =>'Date de naissance',
                                                          'placeholder' => 'jj/mm/aaaa'))
            ->add('adresse', TextType::class)
            ->add('copos', TextType::class)
            ->add('ville', TextType::class)
            ->add('tel', TextType::class)
            ->add('compte', CompteType::class)
			->add('enregistrer', SubmitType::class, array('label' => 'Nouvel usager'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usager::class,
        ]);
    }
}
