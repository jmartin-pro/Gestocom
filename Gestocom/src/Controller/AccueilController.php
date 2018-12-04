<?php

namespace App\Controller;

use App\Entity\Usager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController {

	public function indexAction() {

		return $this->render('accueil/index.html.twig');
	}

}
