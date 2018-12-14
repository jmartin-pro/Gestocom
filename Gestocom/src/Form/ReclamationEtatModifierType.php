<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Etat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReclamationEtatModifierType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('etat',EntityType::class,array(
                'class' => Etat::class,
                'choice_label'=>'libelle'
              ))
			->add('envoyer', SubmitType::class, array('label' => 'Envoyer'))
        ;
    }
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}