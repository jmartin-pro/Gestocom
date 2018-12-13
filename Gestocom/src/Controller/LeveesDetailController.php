<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Entity\Levee;
use App\Entity\Usager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LeveesDetailController extends AbstractController {

	public function detailMoisEnCoursAction(Request $request) {
		$user = $request->getSession()->get("user");
		if(!$user instanceof Usager) {
			return $this->redirectToRoute("index");
		}
		
		$levees = $this->getDoctrine()->getRepository(Levee::class)->findMois(date("m"), date("Y"));

		return $this->render('levees_detail/mois_en_cours.html.twig', 
			array("idUser" => $user->getId(),
				"levees" => $levees));
	}
	
	public function detailMois(Request $request, $month, $year) {
		$user = $request->getSession()->get("user");
		if(!$user instanceof Usager) {
			return $this->redirectToRoute("index");
		}
		
		$levees = $this->getDoctrine()->getRepository(Levee::class)->findMois($month, $year);

		return $this->render('levees_detail/mois_en_cours.html.twig', 
			array("idUser" => $user->getId(),
				"levees" => $levees)); 
	}
	
	public function detailAnneeEnCoursAction(Request $request) {
		$user = $request->getSession()->get("user");
		if(!$user instanceof Usager) {
			return $this->redirectToRoute("index");
		}
		
		$levees = $this->getDoctrine()->getRepository(Levee::class)->findAnneeEnCours();

		return $this->render('levees_detail/annees_precedentes.html.twig', 
			array("idUser" => $user->getId(),
				"levees" => $levees));
	}
	
	public function pdfDetailMois(Request $request, $month, $year) {
		$name = "Detail_levees_".$month."_".$year.".pdf";
		
		$levees = $this->getDoctrine()->getRepository(Levee::class)->findMois($month, $year);
		$html = $this->renderView('levees_detail/pdf.html.twig', 
			array("idUser" => 1,
				"levees" => $levees,
				"month" => date("F", strtotime("2000-".$month."-01")),
				"year" => $year));
				
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$options->setLogOutputFile("/var/tmp/log-pdf");
		
		$dompdf = new Dompdf($options);		
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->setBasePath(substr($_SERVER['DOCUMENT_ROOT'], 0, -1));
		$dompdf->render();
		$dompdf->stream($name);
		
		return $this->redirectToRoute("leveesMois");
	}

}
