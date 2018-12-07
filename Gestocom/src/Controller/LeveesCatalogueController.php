<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LeveesCatalogueController extends AbstractController {

	public function consulterCatalogueLevees() {

		return $this->render('levees_catalogue/consulterCatalogue.html.twig');
	}

}

