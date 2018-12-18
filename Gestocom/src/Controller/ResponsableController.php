<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Entity\Responsable;

use App\Form\ResponsableType;
use App\Form\ResponsableModifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ResponsableController extends AbstractController {
	
	public function ajouterResponsable (Request $request)
	{
		
		$responsable = new Responsable();
		$form = $this->createForm(ResponsableType::class, $responsable);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$responsable = $form->getData();
			$responsable->setArchive(false);
			
			$compte = $responsable->getCompte();
			$mdp = hash("sha256", $compte->getMdp());
			$compte->setMdp($mdp);
			$compte->setArchive(false);
			$responsable->setCompte($compte);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($responsable);
			$entityManager->flush();
	   
			return $this->redirectToRoute("consulterResponsable", array("id" => $responsable->getId()));
		} 
		else {
			return $this->render('responsable/ajouterResponsable.html.twig', array('form' => $form->createView(),"titre"=>"Ajout "));
		}
		
	}
	
	public function consulterResponsable($id)
	{
		
		$responsable = $this->getDoctrine()
        ->getRepository(Responsable::class)
        ->find($id);

		if (!$responsable) {
			throw $this->createNotFoundException(
            'Aucun responsable trouvé avec le numéro '.$id
			);
		}

		//return new Response('Usager : '.$usager->getLogin());
		return $this->render('responsable/consulterResponsable.html.twig', [
            'responsable' => $responsable,]);
	}
	
	public function listerResponsable()
	{
		$repository = $this->getDoctrine()->getRepository(Responsable::class);
		$listeResponsable = $repository->findByArchive(false);
		return $this->render('responsable/listerResponsables.html.twig', [
            'listeResponsable' => $listeResponsable,]);
	}
	
	public function modifierResponsable($id, Request $request){

	//récupération du usager dont l'id est passé en paramètre
	$responsable = $this->getDoctrine()
		->getRepository(Responsable::class)
		->find($id);

		if (!$responsable) {
			throw $this->createNotFoundException('Aucun responsable trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(ResponsableModifierType::class, $responsable);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $responsable = $form->getData();
				 
				$compte = $responsable->getCompte();
				$mdp = hash("sha256", $compte->getMdp());
				$compte->setMdp($mdp);
				$compte->setArchive(false);
				$responsable->setCompte($compte);
				 
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($responsable);
                 $entityManager->flush();
                 return $this->redirectToRoute("consulterResponsable", array("id" => $responsable->getId()));
           }
           else{
                return $this->render('responsable/ajouterResponsable.html.twig', array('form' => $form->createView(),'titre' =>"Modification "));
           }
        }
	}
	
	public function archiverResponsable($id, Request $request){

		
	$responsable = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
	$responsable -> setArchive(true);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager -> persist($responsable);
    $entityManager -> flush();
    return $this -> redirectToRoute('listerResponsable');
	}
	
}