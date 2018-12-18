<?php

namespace App\Form;

use App\Entity\Responsable;
use App\Entity\Utilisateur;
use App\Entity\Compte;

use App\Form\CompteType;
use App\Form\CompteModifierType;

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

class ResponsableModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('disabled'=> true))
            ->add('compte', CompteModifierType::class)
			->add('enregistrer', SubmitType::class, array('label' => 'Modifier Responsable'))
		;
    }
	
	public function getParent(){
      return ResponsableType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
