<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Entity\Usager;
use App\Entity\Responsable;
use App\Entity\Habitation;
use App\Entity\Container;
use App\Entity\Levee;
use App\Entity\TypeDechet;
use App\Entity\Tarif;

use App\Form\ContainerType;
use App\Form\ContainerModifierType;
use App\Form\ContainerArchiverType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ContainerController extends AbstractController
{
    public function ajouterContainer(Request $request)
	{
		
		$container = new Container();
		$form = $this->createForm(ContainerType::class, $container);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$container = $form->getData();
			$container->setArchive(false);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($container);
			$entityManager->flush();
	   
			return $this->redirectToRoute("consulterContainer", array("id" => $container->getId()));
		} 
		else {
			return $this->render('container/ajouter.html.twig', array('form' => $form->createView(),));
		}
		
	}
	
	public function consulterContainer($id)
	{
		
		$container = $this->getDoctrine()
        ->getRepository(Container::class)
        ->find($id);

		if (!$container) {
			throw $this->createNotFoundException(
            'Aucun container trouvé avec le numéro '.$id
			);
		}

		//return new Response('Container : '.$container->getLogin());
		return $this->render('container/consulter.html.twig', [
            'container' => $container,]);
	}
	
	public function listerContainer()
	{
		$repository = $this->getDoctrine()->getRepository(Container::class);
		$containers = $repository->findByArchive(false);
		return $this->render('container/lister.html.twig', [
            'pContainers' => $containers,]);
	}
	
	public function containersHabitation($id)
    {
		$habitation = $this->getDoctrine()->getRepository(Habitation::class)->findById($id);

        $repository = $this->getDoctrine()->getRepository(Container::class);
        $listeContainer = $repository->findBy(['habitation' => $habitation,'archive' => false ]);
    
        return $this->render('container/lister.html.twig', ['pContainers' => $listeContainer]);

    }
	
	public function modifierContainer($id, Request $request){

	//récupération du container dont l'id est passé en paramètre
	$container = $this->getDoctrine()
		->getRepository(Container::class)
		->find($id);

		if (!$container) {
			throw $this->createNotFoundException('Aucun container trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(ContainerModifierType::class, $container);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $container = $form->getData();
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($container);
                 $entityManager->flush();
                 return $this->redirectToRoute("consulterContainer", array("id" => $container->getId()));
           }
           else{
                return $this->render('container/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
	
	public function archiverContainer($id, Request $request){

	//récupération du container dont l'id est passé en paramètre
	$container = $this->getDoctrine()
		->getRepository(Container::class)
		->find($id);

		if (!$container) {
			throw $this->createNotFoundException('Aucun container trouvé avec le numéro '.$id);
		}
		else
		{
            $form = $this->createForm(ContainerArchiverType::class, $container);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                 $container = $form->getData();
				 
				 $container->setArchive(true);
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($container);
                 $entityManager->flush();
				return $this->redirectToRoute("consulterContainer", array("id" => $container->getId()));
           }
           else{
                return $this->render('container/ajouter.html.twig', array('form' => $form->createView(),));
           }
        }
	}
}
