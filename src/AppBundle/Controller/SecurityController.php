<?php

// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
	public function loginAction(Request $request)
	{
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
		{
			return $this->redirectToRoute('default_security_target');
		}
			
	    $authenticationUtils = $this->get('security.authentication_utils');
	
	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();
	
	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();
	
	    return $this->render(
	        'security/login.html.twig',
	        array(
	            // last username entered by the user
	            'last_username' => $lastUsername,
	            'error'         => $error,
	        )
	    );
	}

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
    
    /**
     * @Route("/default_security_target", name="default_security_target")
     */
    public function default_security_target()
    { 
    	if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
    	{
    		return $this->redirectToRoute('admin_main');
    	}
    	else if($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) 
    	{
    		return $this->redirectToRoute('teacher_main');
    	}
    	else if($this->get('security.authorization_checker')->isGranted('ROLE_STUDENT')) 
    	{
    		return $this->redirectToRoute('student_main');
    	}
    	else return $this->redirectToRoute('homepage');	
    }
     
}
