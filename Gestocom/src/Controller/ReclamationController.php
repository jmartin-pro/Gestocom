<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ReclamationType;

use App\Entity\Reclamation;
use App\Entity\Usager;
use App\Entity\Responsable;
use App\Entity\Etat;
use App\Entity\Utilisateur;
use App\Entity\Reponse;

use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UsagerRepository;
use App\Repository\EtatRepository;

class ReclamationController extends AbstractController
{
    public function consulterReclamation($id)
    {
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $uneReclamation = $repository->findOneById($id);
        return $this->render('Reclamation/consulterReclamation.html.twig', [
            'reclamation' => $uneReclamation]);
    }
    
    public function listerReclamations(Request $request){
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
    
    public function ajouterReclamation(Request $request){
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
