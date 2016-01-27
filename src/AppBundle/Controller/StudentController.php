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
		$conn = $this->get('database_connection');
		$id_student = $this->getUser()->getId();
		
		$sql = sprintf
		(
			'SELECT p.nazwa as przedmiotNazwa, g.nazwa as grupaNazwa, t.name as imieProwadzacy, t.surname as nazwiskoProwadzacy, zs.id as idZajeciaStudent
				FROM przedmiot as p, grupa as g, teacher as t, zajecia as z, student as s, zajeciastudent as zs
			 WHERE g.id = z.grupa_id AND p.id = z.przedmiot_id AND t.id = z.teacher_id AND z.id = zs.zajecia_id AND s.id = zs.student_id
			   AND s.id = "%s"',$id_student
		);
		$zajeciaStudenta = $conn->fetchAll($sql);
						
		return $this->render('student/student.html.twig',
				array('zajeciaStudenta' => $zajeciaStudenta));	
	}
	
	/**
	 * @Route("/student/oceny")
	 */
	public function oceny(Request $request)
	{
		$conn = $this->get('database_connection');
	
		$przedmiotNazwa = $request->request->get('przedmiotNazwa');
    	$grupaNazwa = $request->request->get('grupaNazwa'); 	
    	$imieProwadzacy = $request->request->get('imieProwadzacy');
    	$nazwiskoProwadzacy = $request->request->get('nazwiskoProwadzacy');
    	$idZajeciaStudent = $request->request->get('idZajeciaStudent');
    	
    	$sql = sprintf
    	(
    		'SELECT o.wartosc, o.komentarz 
    		   FROM ocena as o, zajeciastudent as zs
    		  WHERE zs.id = o.zajeciastudent_id
    		    AND zs.id = "%s"',$idZajeciaStudent	
    	);
    	$oceny= $conn->fetchAll($sql);
    	
    	return $this->render('student/oceny.html.twig',
    			array('oceny' => $oceny,
    				  'przedmiotNazwa' => $przedmiotNazwa,
    				  'grupaNazwa' => $grupaNazwa,
    				  'imieProwadzacy' => $imieProwadzacy,
    				  'nazwiskoProwadzacy' => $nazwiskoProwadzacy,		
    			));	
	}
	
	
}
