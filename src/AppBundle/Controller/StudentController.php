<?php

// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
	/**
	 * @Route("/student", name="student_main")
	 */
	public function main()
	{				
		$grupa = $this->getDoctrine()
			->getRepository('AppBundle:Grupa')
			->find(2);
		
		return $this->render(
				'student/student.html.twig',
				array('grupa' => $grupa));
		
	}
}
