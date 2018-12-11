<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

use App\Form\TypeDechetModifierType;
use App\Form\TypeDechetType;
use App\Entity\TypeDechet;
use App\Entity\Tarif;
use App\Repository\TypeDechetRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TypeDechetController extends AbstractController
{
     
    public function listerTypeDechet()
    {

        $repository = $this->getDoctrine()->getRepository(TypeDechet::class);
        $listeTypeDechet = $repository->findAllTarifActuel();
        $repository = $this->getDoctrine()->getRepository(Tarif::class);

        return $this->render('type_dechet/listerTypeDechet.html.twig', [
                     'listeTypeDechet' => $listeTypeDechet
        ]);

    }

    public function ajouterTypeDechet(Request $request)
    {

        $typeDechet = new typeDechet();
        $form = $this->createForm(TypeDechet::class, $typeDechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $typeDechet = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeDechet);
            $entityManager->flush();
    
            return $this->redirectToRoute('listerTypeDechet');

        }

        else
        {

            return $this->render('type_dechet/formTypeDechet.html.twig', array('formTypeDechet' => $form->createView(),  "typeDechet" => $typeDechet,));

        }
    }

    public function modifierTypeDechet($id, Request $request)
    {

        $typeDechet = $this->getDoctrine()
            ->getRepository(TypeDechet::class)
            ->find($id);
    
        if (!$typeDechet) 
        {

            throw $this->createNotFoundException('Aucun type de déchet trouvé avec le numéro '.$id);

        }
        else
        {

                $form = $this->createForm(TypeDechetModifierType::class, $typeDechet);
                $form->handleRequest($request);
    
                if ($form->isSubmitted() && $form->isValid())
                {
    
                     $typeDechet = $form->getData();
                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($typeDechet);
                     $entityManager->flush();
                     return $this->render('type_dechet/listerTypeDechet.html.twig', ['typeDechet' => $typeDechet,]);

               }
               else
               {

                    return $this->render('type_dechet/formTypeDechet.html.twig', array('formTypeDechet' => $form->createView(), "typeDechet" => $typeDechet,));
                    
               }
            }
     }

    public function archiverTypeDechet($id)
    {

        $typeDechet = $this->getDoctrine()->getRepository(TypeDechet::class)->find($id);
        $typeDechet -> setArchiver(1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager -> persist($typeDechet);
        $entityManager -> flush();
        return $this -> redirectToRoute('listerTypeDechet');

    }
}

