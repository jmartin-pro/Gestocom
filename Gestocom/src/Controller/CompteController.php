<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Entity\Usager;
use App\Entity\Responsable;
use App\Entity\Habitation;


use App\Form\CompteType;
use App\Form\CompteModifierType;
use App\Form\CompteArchiverType;
use App\Form\CompteReinitMdpType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CompteController extends AbstractController
{	
	public function ajouterCompte(Request $request)
	{
		
		$compte = new Compte();
		$form = $this->createForm(CompteType::class, $compte);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$compte = $form->getData();
			$mdp = hash("sha256", $compte->getMdp());
			$compte->setMdp($mdp);
			$compte->setArchive(false);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($compte);
			$entityManager->flush();
	   
			return $this->render('compte/consulter.html.twig', ['compte' => $compte,]);
		}
		else{
			return $this->render('compte/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
	}
	
	public function consulterCompte($id)
	{
		
		$compte = $this->getDoctrine()
        ->getRepository(Compte::class)
        ->find($id);

		if (!$compte) {
			throw $this->createNotFoundException(
            'Aucun compte trouvé avec le numéro '.$id
			);
		}

		//return new Response('Compte : '.$compte->getLogin());
		return $this->render('compte/consulter.html.twig', [
            'compte' => $compte,]);
	}
	
	public function listerCompte()
	{
		$repository = $this->getDoctrine()->getRepository(Compte::class);
		$comptes = $repository->findByArchive(false);
		return $this->render('compte/lister.html.twig', [
            'pComptes' => $comptes,]);
	}
	
	public function modifierCompte($id, Request $request){

	//récupération du compte dont l'id est passé en paramètre
	$compte = $this->getDoctrine()
		->getRepository(Compte::class)
		->find($id);

		if (!$compte) {
			throw $this->createNotFoundException('Aucun compte trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(CompteModifierType::class, $compte);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $compte = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($compte);
                 $entityManager->flush();
                 return $this->render('compte/consulter.html.twig', ['compte' => $compte,]);
           }
           else{
                return $this->render('compte/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
	
	public function reinitMdpCompte($id, Request $request){

	//récupération du compte dont l'id est passé en paramètre
	$compte = $this->getDoctrine()
		->getRepository(Compte::class)
		->find($id);

		if (!$compte) {
			throw $this->createNotFoundException('Aucun compte trouvé avec le numéro '.$id);
		}
		else
		{
				$mdp = hash("sha256", "test");
				$compte->setMdp($mdp);
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($compte);
                 $entityManager->flush();
                 return $this->render('usager/consulter.html.twig', ['usager' => $compte->getUtilisateur(),]);
           
           
        }
	}
	
	public function archiverCompte($id, Request $request){

	//récupération du compte dont l'id est passé en paramètre
	$compte = $this->getDoctrine()
		->getRepository(Compte::class)
		->find($id);

		if (!$compte) {
			throw $this->createNotFoundException('Aucun compte trouvé avec le numéro '.$id);
		}
		else
		{
            
				 $compte->setArchive(true);
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($compte);
                 $entityManager->flush();
				 $repository = $this->getDoctrine()->getRepository(Compte::class);
				$comptes = $repository->findAll();
				return $this->render('compte/lister.html.twig', ['pComptes' => $comptes,]);
           
        }
	}
}
