<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReclamationType;
use App\Form\ReponseType;
use App\Form\ReclamationEtatModifierType;
use App\Entity\Reclamation;
use App\Entity\Usager;
use App\Entity\Responsable;
use App\Entity\Etat;
use App\Entity\Utilisateur;
use App\Entity\Reponse;

class ReclamationController extends AbstractController {

	public function consulterReclamation($id, Request $request) {
		$user = $request->getSession()->get("user");
		$repository = $this->getDoctrine()->getRepository(Reclamation::class);
		$uneReclamation = $repository->findOneById($id);

		//Ajout d'une reponse
		$reponse = new Reponse();
		$form = $this->createForm(ReponseType::class, $reponse);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$reponse = $form->getData();
			//On configure les champs par défauts
			$reponse->setDate(new \DateTime(date('m/d/Y h:i:s a', time())));
			$reponse->setUtilisateur($this->getDoctrine()->getRepository(Utilisateur::class)->findOneById($user->getId()));
			$reponse->setReclamation($this->getDoctrine()->getRepository(Reclamation::class)->findOneById($id));
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($reponse);
			$entityManager->flush();
			return $this->redirectToRoute('consulterReclamation',array("id"=> $id));
		}
		
		$etatReclamation = new Etat();
		$formEtat = $this->createForm(ReclamationEtatModifierType::class, $uneReclamation);
		$formEtat->handleRequest($request);
		
		//Changement de l'etat en tant que responsable
		if ($user instanceof Responsable) {
			if ($formEtat->isSubmitted() && $formEtat->isValid()) {
				$etatReclamation = $formEtat->getData();
				if ($etatReclamation->getEtat()->getId() != 1){
					$etatReclamation->setDateFerm(new \DateTime(date('m/d/Y h:i:s a', time())));
				}
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($etatReclamation);
				$entityManager->flush();
				return $this->redirectToRoute('consulterReclamation',array("id"=> $id));
			}
		}

		return $this->render('reclamation/consulterReclamation.html.twig', array("reclamation" => $uneReclamation, "form" => $form->createView(), 
			"etat" =>$uneReclamation->getEtat(), "formEtat" => $formEtat->createView()));
	}

	public function listerReclamations(Request $request) {
		$user = $request->getSession()->get("user");
		if ($user == null) {
			return $this->redirectToRoute("index");
		}

		$repository = $this->getDoctrine()->getRepository(Reclamation::class);
		$listeReclamation = array();
		//Si l'utilisateur est un Usager on recupere uniquement ses reclamations sinon si on est responsable on les recuperes toutes
		if ($user instanceof Usager) {
			$listeReclamation = $repository->findByUsager($user->getId());
		} else if ($user instanceof Responsable) {
			$listeReclamation = $repository->findAll();
		}


		return $this->render('reclamation/listerReclamations.html.twig', [
					'listeReclamation' => $listeReclamation]);
	}

	public function ajouterReclamation(Request $request) {
		$user = $request->getSession()->get("user");
		if ($user == null) {
			return $this->redirectToRoute("index");
		} else if (!$user instanceof Usager) {
			return $this->redirectToRoute("index");
		}

		$reclamation = new Reclamation();
		$form = $this->createForm(ReclamationType::class, $reclamation);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$reclamtion = $form->getData();
			//On configure les champs par défauts
			$reclamation->setDateOuv(new \DateTime(date('m/d/Y h:i:s a', time())));
			$reclamation->setUsager($this->getDoctrine()->getRepository(Usager::class)->findOneById($user->getId()));
			$reclamation->setEtat($this->getDoctrine()->getRepository(Etat::class)->findOneById(1));

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($reclamation);
			$entityManager->flush();

			return $this->redirectToRoute("listerReclamations");
		}

		return $this->render('reclamation/formReclamation.html.twig', array("form" => $form->createView()));
	}

}
