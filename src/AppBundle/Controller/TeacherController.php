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
	public function main(Request $request)
	{
		$id_forma = $request->request->get('forma');
		$id_przedmiot = $request->request->get('przedmiot');
					
		$conn = $this->get('database_connection');
		$id_teacher = $this->getUser()->getId();
	
		$dostepnePrzedmoty = $conn->fetchAll
		(
			'SELECT DISTINCT p.id, p.nazwa 
				FROM przedmiot as p, zajecia as z
			 WHERE p.id = z.przedmiot_id
				AND z.teacher_id = '.$id_teacher
		);
		
		$dostepneFormy = $conn->fetchAll
		(
			'SELECT DISTINCT f.id, f.nazwa 
				FROM formazajec as f, grupa as g, zajecia as z
			 WHERE f.id = g.formazajec_id
				AND g.id = z.grupa_id
				AND  z.teacher_id = '.$id_teacher		
		);
		
		
		$sql = 'SELECT z.id, p.nazwa as przedmiot_nazwa, g.nazwa as grupa_nazwa
					FROM formazajec as f, grupa as g, zajecia as z, przedmiot as p
		 		WHERE f.id = g.formazajec_id
		 			AND g.id = z.grupa_id
		 			AND p.id = z.przedmiot_id';

		if($request->request->has('przedmiot'))
		{	
			if($id_przedmiot != 'dowolnie')
			{
				$sql .= ' AND p.id = '.$id_przedmiot;
			}
		}
		
		if($request->request->has('forma'))
		{
			if($id_forma != 'dowolnie')
			{
				$sql .= ' AND f.id ='.$id_forma;
			}
		}		
		$zajecia = $conn->fetchAll($sql);
		
		return $this->render('teacher/teacher.html.twig',
		 		array('dostepnePrzedmoty' => $dostepnePrzedmoty,
		 			  'dostepneFormy' => $dostepneFormy,
					  'zajecia' => $zajecia
		 		));
	}
	
	/**
	 * @Route("/teacher/studenci", name="teacher_studenci")
	 */
	public function studenci(Request $request)
	{
		$conn = $this->get('database_connection');
		
		$grupa = $request->request->get('grupa');
		$przedmiot = $request->request->get('przedmiot');
		$id_zajecia= $request->request->get('id_zajecia');
		
		$studenci = $conn->fetchAll
		(
			'SELECT s.name, s.surname, zs.id
				 FROM zajecia z, zajeciastudent zs, student s
			 WHERE z.id = zs.zajecia_id
				AND s.id = zs.student_id
				AND z.id = '.$id_zajecia
		);
				
		return $this->render('teacher/studenci.html.twig',
				array('grupa' => $grupa,
					  'przedmiot' => $przedmiot,
					  'studenci' => $studenci
				));	
	}
	
	/**
	 * @Route("/teacher/student", name="teacher_student")
	 */
	public function student(Request $request)
	{
		$conn = $this->get('database_connection');
		$name = $request->request->get('name');
		$surname = $request->request->get('surname');
		$id_zajeciastudent = $request->request->get('id_zajeciastudent');
					
		$oceny = $conn->fetchAll
		(
			'SELECT * FROM ocena
				WHERE zajeciastudent_id='.$id_zajeciastudent
		);	
		
		return $this->render('teacher/student.html.twig',
				array('oceny' => $oceny,
					  'name' => $name,
					  'surname' => $surname,
					  'id_zajeciastudent' => $id_zajeciastudent
				));
	}
	
	
	/**
	 * @Route("/teacher/dodaj", name="teacher_dodaj")
	 */
	public function dodaj(Request $request)
	{
		$conn = $this->get('database_connection');
		$wartosc = $request->request->get('wartosc');
		$komentarz = $request->request->get('komentarz');
		$id_zajeciastudent = $request->request->get('id_zajeciastudent');
				
		$sql = sprintf('INSERT INTO ocena SET wartosc="%s",komentarz="%s", zajeciastudent_id ="%s"',$wartosc,$komentarz,$id_zajeciastudent);
		$conn->query($sql);
		
		return $this->redirectToRoute('teacher_student', [
				'request' => $request
		], 307);
		
	}
	
	/**
	 * @Route("/teacher/usun", name="teacher_usun")
	 */
	public function usun(Request $request)
	{
		$conn = $this->get('database_connection');
		$id = $request->request->get('id');
	
		$sql =  sprintf('DELETE FROM ocena WHERE id = "%s"',$id);	
		$conn->query($sql);
	
		return $this->redirectToRoute('teacher_student', [
				'request' => $request
		], 307);
	
	}
	
}
