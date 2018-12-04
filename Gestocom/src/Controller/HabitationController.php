<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Habitation;
use App\Repository\HabitationRepository;

class HabitationController extends AbstractController
{
    /**
     * @Route("/habitation", name="habitation")
     */

    public function listerHabitation()
    {
        $repository = $this->getDoctrine()->getRepository(Habitation::class);
        $listeHabitation = $repository->findAll();
    
        return $this->render('habitation/listerHabitation.html.twig', [
                     'listeHabitation' => $listeHabitation
        ]);
    }
}