<?php

namespace App\Controller;

use App\Entity\Levee;
use App\Entity\Usager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LeveesDetailController extends AbstractController {

	public function detailMoisEnCoursAction(Request $request) {
		$user = $request->getSession()->get("user");
		if($user instanceof Usager) {
			$levees = $this->getDoctrine()->getRepository(Levee::class)->findMoisEnCours();

			return $this->render('levees_detail/mois_en_cours.html.twig', 
				array("idUser" => $user->getId(),
					"levees" => $levees));
		} 
		
		return $this->redirectToRoute("index");
		
	}

}
