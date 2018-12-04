<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AuthentificationType;
use App\Entity\Compte;

class AuthentificationController extends AbstractController {

	public function connexionAction(Request $request) {
		$compte = new Compte();
		$form = $this->createForm(AuthentificationType::class, $compte);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$compte = $form->getData();
			$compteBdd = $this->getDoctrine()->getRepository(Compte::class)->findOneByLogin($compte->getLogin());

			if($compteBdd != null && hash("sha256", $compte->getMdp()) == $compteBdd->getMdp()) {
				$request->getSession()->set("user", $compteBdd->getUtilisateur());
				return $this->redirectToRoute("index");
			}
		}

		return $this->render('authentification/connexion.html.twig', array("form" => $form->createView()));
	}

	public function deconnexionAction(Request $request) {
		$request->getSession()->clear();

		return $this->redirectToRoute("index");
	}

}
