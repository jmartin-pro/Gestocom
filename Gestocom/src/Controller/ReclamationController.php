<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use App\Entity\Usager;
use App\Repository\UsagerRepository;


use App\Entity\Etat;
use App\Repository\EtatRepository;

class ReclamationController extends AbstractController
{
    public function listerReclamations(){

        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $listeReclamation = $repository->findAll();
    
        return $this->render('reclamation/listerReclamations.html.twig', [
            'listeReclamation' => $listeReclamation]);
    }
}
