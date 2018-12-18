<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    
    public function index()
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
	
	public function pageContact()
    {
        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}