<?php

// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;

class TeacherController extends Controller
{
	/**
	 * @Route("/teacher", name="teacher_main")
	 */
	public function main()
	{
		/*$zajecia = $this->getDoctrine()
        	->getRepository('AppBundle:Zajecia')
        	->findByTeacher(1);*/

		
		return $this->render('teacher/teacher.html.twig',
				array('zajecia' => $zajecia));
	}
}
