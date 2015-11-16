<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 */
    public function index()
    {	  	
		return $this->redirectToRoute('login');			
    }
      

    
}
