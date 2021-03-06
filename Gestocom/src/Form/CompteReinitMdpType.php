<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CompteReinitMdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, array('disabled'=> true))
            ->add('mdp', TextType::class, array('disabled'=> true))
            ->add('utilisateur', EntityType::class, array('class' => 'App\Entity\Utilisateur','choice_label' => 'nom', 'disabled'=> true ))
			->add('enregistrer', SubmitType::class, array('label' => 'Réinitialiser le mot de passe'))
        ;
    }
	
	
	public function getParent(){
      return CompteType::class;
    }
	
	
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
