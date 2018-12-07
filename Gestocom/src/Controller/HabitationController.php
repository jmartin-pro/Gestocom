<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

use App\Form\HabitationModifierType;
use App\Form\HabitationType;
use App\Entity\Habitation;
use App\Entity\Usager;
use App\Repository\HabitationRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HabitationController extends AbstractController
{
     
    public function consulterHabitation($id)
    {
        $repository = $this->getDoctrine()->getRepository(Habitation::class);
        $uneHabitation = $repository->findOneById($id);
        return $this->render('habitation/consulterHabitation.html.twig', [
            'habitation' => $uneHabitation]);
    }


    public function listerHabitation()
    {

        $repository = $this->getDoctrine()->getRepository(Habitation::class);
        $listeHabitation = $repository->findAll();
    
        return $this->render('habitation/listerHabitation.html.twig', [
                     'listeHabitation' => $listeHabitation
        ]);

    }

    public function ajouterHabitation(Request $request)
    {

        $habitation = new habitation();
        $form = $this->createForm(HabitationType::class, $habitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $habitation = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($habitation);
            $entityManager->flush();
    
            return $this->redirectToRoute('listerHabitation');

        }

        else
        {

            return $this->render('habitation/ajouterHabitation.html.twig', array('formHabitation' => $form->createView(),));

        }
    }

    public function modifierHabitation($id, Request $request){

        //récupération de l'étudiant dont l'id est passé en paramètre
        $habitation = $this->getDoctrine()
            ->getRepository(Habitation::class)
            ->find($id);
    
        if (!$habitation) {
            throw $this->createNotFoundException('Aucune habitation trouvé avec le numéro '.$id);
        }
        else
        {
                $form = $this->createForm(HabitationModifierType::class, $habitation);
                $form->handleRequest($request);
    
                if ($form->isSubmitted() && $form->isValid()) {
    
                     $habitation = $form->getData();
                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($habitation);
                     $entityManager->flush();
                     return $this->render('habitation/consulter.html.twig', ['habitation' => $habitation,]);
               }
               else{
                    return $this->render('habitation/ajouter.html.twig', array('form' => $form->createView(),));
               }
            }
     }
}

