<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
	/**
	 * @Route("/admin", name="admin_main")
	 */
    public function main()
    {
    	return $this->redirectToRoute('admin_prowadzacy');	
    }
    
    /**
     * @Route("/admin/prowadzacy", name="admin_prowadzacy")
     */
    public function prowadzacy()
    {
    	$conn = $this->get('database_connection');
    	
    	$prowadzacy = $conn->fetchAll('SELECT * FROM teacher WHERE active=1');
    	
    	$nieaktywniProwadzacy = $conn->fetchAll('SELECT * FROM teacher WHERE active=0');

    	
    	return $this->render('admin/prowadzacy.html.twig',
    			array('prowadzacy' => $prowadzacy,
    				  'nieaktywniProwadzacy' => $nieaktywniProwadzacy					
    			));
    }
    
    /**
     * @Route("/admin/usunProwadzacy")
     */
    public function usunProwadzacego(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$teacher_id= $request->request->get('id');
    	
		$sql = sprintf('UPDATE teacher SET active=0 WHERE id="%s"',$teacher_id);
		$conn->query($sql);
    		
		$this->addFlash(
   			'notice',
			'Usunięto prowadzącego!'
			);
    	
    	return $this->redirectToRoute('admin_prowadzacy');
    }


    /**
     * @Route("/admin/dodajProwadzacego")
     */
    public function dodajProwadzacego(Request $request)
    {
    	$conn = $this->get('database_connection');
    	
    	$login= $request->request->get('login');
    	$haslo= $request->request->get('haslo');
    	$imie= $request->request->get('imie');
    	$nazwisko= $request->request->get('nazwisko');
    	  	
    	$sql = sprintf('SELECT login FROM teacher WHERE login = "%s"',$login);
    	$prowadzacy = $conn->fetchAll($sql);
    	

    	if($prowadzacy)
    	{	
    		$this->addFlash(
    				'notice',
    				'Prowadzący o takim loginie już istnieje!'
    				);
    	}
    	else
    	{
    		$sql = sprintf('INSERT INTO teacher SET login ="%s", password="%s", name="%s", surname="%s", active=1',$login,$haslo,$imie,$nazwisko);
    		$conn->query($sql);
    		
    		$this->addFlash(
    				'notice',
    				'Dodano prowadzącego!'
    				); 		
    	}
    	  	
    	return $this->redirectToRoute('admin_prowadzacy');
    }
    
    /**
     * @Route("/admin/przywrocProwadzacego", name="admin_przywrocProwadzacy")
     */
    public function przywrocProwadzacego(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$teacher_id= $request->request->get('teacher_id');
    	 
    	$sql = sprintf('UPDATE teacher SET active=1 WHERE id="%s"',$teacher_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Przywrócono prowadzącego!'
    			);
    	 
    	return $this->redirectToRoute('admin_prowadzacy');
    }
     
    /**
     * @Route("/admin/studenci", name="admin_studenci")
     */
    public function studenci()
    {
    	$conn = $this->get('database_connection');
    	 
    	$student = $conn->fetchAll('SELECT * FROM student WHERE active=1');
    	$nieaktywniStudenci = $conn->fetchAll('SELECT * FROM student WHERE active=0');
    		
    	return $this->render('admin/studenci.html.twig',
    			array('student' => $student,
    				  'nieaktywniStudenci' => $nieaktywniStudenci				
    			));
    }
    
    /**
     * @Route("/admin/dodajStudenta", name="admin_dodajStudent")
     */
    public function dodajStudenta(Request $request)
    {
		$conn = $this->get('database_connection');
    	
    	$login= $request->request->get('login');
    	$haslo= $request->request->get('haslo');
    	$imie= $request->request->get('imie');
    	$nazwisko= $request->request->get('nazwisko');
    	  	
    	$sql = sprintf('SELECT login FROM student WHERE login = "%s"',$login);
    	$student = $conn->fetchAll($sql);
    	    	
    	if($student)
    	{	
    		$this->addFlash(
    				'notice',
    				'Student o takim lognie już istnieje!'
    				);
    	}
    	else
    	{
    		$sql = sprintf('INSERT INTO student SET login ="%s", password="%s", name="%s", surname="%s", active=1',$login,$haslo,$imie,$nazwisko);
    		$conn->query($sql);
    		
    		$this->addFlash(
    				'notice',
    				'Dodano studenta!'
    				); 		
    	}
    	  	
    	return $this->redirectToRoute('admin_studenci');
    }
    
    /**
     * @Route("/admin/usunStudenta")
     */
    public function usunStudenta(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$student_id= $request->request->get('id');
    	 
    	$sql = sprintf('UPDATE student SET active=0 WHERE id="%s"',$student_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Usunięto studenta!'
    			);
    	 
    	return $this->redirectToRoute('admin_studenci');
    }
    
    /**
     * @Route("/admin/przywrocStudenta")
     */
    public function przywrocStudenta(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$student_id= $request->request->get('student_id');
    
    	$sql = sprintf('UPDATE student SET active=1 WHERE id="%s"',$student_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Przywrócono studenta!'
    			);
    
    	return $this->redirectToRoute('admin_studenci');
    }
    
    /**
     * @Route("/admin/przedmioty", name="admin_przedmioty")
     */
    public function przedmioty()
    {
    	$conn = $this->get('database_connection');
    
    	$przedmiot = $conn->fetchAll('SELECT * FROM przedmiot WHERE active=1');
    	$nieaktywnePrzedmioty = $conn->fetchAll('SELECT * FROM przedmiot WHERE active=0');
    
    	return $this->render('admin/przedmioty.html.twig',
    			array('przedmiot' => $przedmiot,
    				  'nieaktywnePrzedmioty' => $nieaktywnePrzedmioty
    			));
    }
    
    /**
     * @Route("/admin/dodajPrzedmiot", name="admin_dodajPrzedmiot")
     */
    public function dodajPrzedmiot(Request $request)
    {
    	$conn = $this->get('database_connection');
    	
    	$nazwa= $request->request->get('nazwa');
    	
    	$sql = sprintf('SELECT nazwa FROM przedmiot WHERE nazwa="%s"',$nazwa);
    	$przedmiot = $conn->fetchAll($sql);
    	
    	if($przedmiot)
    	{
    		$this->addFlash(
    				'notice',
    				'Przedmiot o takiej nazwie już istnieje!'
    				);
    	}
    	else
    	{
    		$sql = sprintf('INSERT INTO przedmiot SET nazwa ="%s", active=1',$nazwa);
    		$conn->query($sql);
    		
    		$this->addFlash(
    				'notice',
    				'Dodano przedmiot!'
    				);
    	}
    	   	
    	return $this->redirectToRoute('admin_przedmioty');
    }
    
    /**
     * @Route("/admin/usunPrzedmiot")
     */
    public function usunPrzedmiot(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$przedmiot_id= $request->request->get('id');
    
    	$sql = sprintf('UPDATE przedmiot SET active=0 WHERE id="%s"',$przedmiot_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Usunięto przedmiot!'
    			);
    
    	return $this->redirectToRoute('admin_przedmioty');
    }
    
    /**
     * @Route("/admin/przywrocPrzedmiot")
     */
    public function przywrocPrzedmiot(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$przedmiot_id= $request->request->get('id');
    
    	$sql = sprintf('UPDATE przedmiot SET active=1 WHERE id="%s"',$przedmiot_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Przywrócono przedmiot!'
    			);
    
    	return $this->redirectToRoute('admin_przedmioty');
    }
    
  
    /**
     * @Route("/admin/formyZajec", name="admin_formyZajec")
     */
    public function formyZajec()
    {
    	$conn = $this->get('database_connection');
    	
    	$forymZajec = $conn->fetchAll('SELECT * FROM formazajec');
    	
    	return $this->render('admin/formyZajec.html.twig',
    			array('forymZajec' => $forymZajec));	
    }
    
    /**
     * @Route("/admin/dodajFormeZajec", name="admin_formZajec")
     */
    public function dodajFormeZajec(Request $request)
    {
    	$conn = $this->get('database_connection');
    	 
    	$nazwa= $request->request->get('nazwa');
    	 
    	$sql = sprintf('SELECT nazwa FROM formazajec WHERE nazwa="%s"',$nazwa);
    	$formaZajec = $conn->fetchAll($sql);
    	 
    	if($formaZajec)
    	{
    		$this->addFlash(
    				'notice',
    				'Forma zajęć o takiej nazwie już istnieje!'
    				);
    	}
    	else
    	{
    		$sql = sprintf('INSERT INTO formazajec SET nazwa ="%s"',$nazwa);
    		$conn->query($sql);
    	
    		$this->addFlash(
    				'notice',
    				'Dodano formę zajęć!'
    				);
    	}
    		
    	return $this->redirectToRoute('admin_formyZajec');
    }
    
    /**
     * @Route("/admin/grupy", name="admin_grupy")
     */
    public function grupy()
    {
    	$conn = $this->get('database_connection');
    
    	
    	$grupy = $conn->fetchAll
    	(
    		 'SELECT g.nazwa as grupaNazwa, g.id as grupaId, f.nazwa as formaNazwa
    		   FROM grupa g, formazajec f
    	      WHERE f.id = g.formazajec_id
    		    AND g.active = 1
    	   ORDER BY f.nazwa'
    	);
    	
    	$nieaktywneGrupy = $conn->fetchAll
    	(
    			'SELECT g.nazwa as grupaNazwa, g.id as grupaId, f.nazwa as formaNazwa
    		   FROM grupa g, formazajec f
    	      WHERE f.id = g.formazajec_id
    		    AND g.active = 0
    	   ORDER BY f.nazwa'
    			);
    	
    		
    	$formy = $conn->fetchAll('SELECT id, nazwa FROM formazajec');
    	   
    	return $this->render('admin/grupy.html.twig',
    			array('grupy' => $grupy,
    				  'nieaktywneGrupy' => $nieaktywneGrupy,
    				  'formy' => $formy
    			));
    }
    
    /**
     * @Route("/admin/dodajGrupe", name="admin_dodajGrupe")
     */
    public function dodajGrupe(Request $request)
    {
    	$conn = $this->get('database_connection');	
    	$formaId= $request->request->get('forma');
    	 	
    	$sql = sprintf('SELECT nazwa FROM grupa WHERE formazajec_id = "%s" ORDER BY id DESC LIMIT 1',$formaId);  	
    	$nazwaGrupy = $conn->fetchColumn($sql);
    	
    	$numerGrupy = substr($nazwaGrupy,1);
    	$numerGrupy = $numerGrupy+1;
    	  	
    	$nazwaGrupy = substr($nazwaGrupy,0,1).$numerGrupy;
    	  		    	
    	$sql = sprintf('INSERT INTO grupa SET nazwa ="%s", formazajec_id="%s", active=1',$nazwaGrupy,$formaId);
    	$conn->query($sql);
    	
    	$this->addFlash(
    			'notice',
    			'Dodano grupe!'
    			);
    	 	
    	return $this->redirectToRoute('admin_grupy');
    }
    
    /**
     * @Route("/admin/usunGrupe")
     */
    public function usunGrupe(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$grupa_id= $request->request->get('id');
    
    	$sql = sprintf('UPDATE grupa SET active=0 WHERE id="%s"',$grupa_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Usunięto grupe!'
    			);
    
    	return $this->redirectToRoute('admin_grupy');
    }
    
    /**
     * @Route("/admin/przywrocGrupe")
     */
    public function przywrocGrupe(Request $request)
    {
    	$conn = $this->get('database_connection');
    	$grupa_id= $request->request->get('id');
    
    	$sql = sprintf('UPDATE grupa SET active=1 WHERE id="%s"',$grupa_id);
    	$conn->query($sql);
    
    	$this->addFlash(
    			'notice',
    			'Przywrócono grupe!'
    			);
    
    	return $this->redirectToRoute('admin_grupy');
    }
    
    
    /**
     * @Route("/admin/zajecia", name="admin_zajecia")
     */
    public function zajecia()
    {
    	$conn = $this->get('database_connection');
    	
    	$przedmioty = $conn->fetchAll('SELECT * FROM przedmiot');
    	$prowadzacy = $conn->fetchAll('SELECT * FROM teacher');
    	$grupa = $conn->fetchAll('SELECT * FROM grupa');
    	  	
    	$sql = sprintf
    	(
			'SELECT g.nazwa as grupaNazwa, t.name as nameProwadzacy, t.surname as surnameProwadzacy, p.nazwa as przedmiotNazwa, z.id as zajecia_id
    			FROM grupa as g, teacher as t, przedmiot as p, zajecia as z
    		 WHERE g.id = z.grupa_id
    		   AND t.id = z.teacher_id
    		   AND p.id = z.przedmiot_id
    		   AND z.active = 1'
    	);
    	
    	$zajecia = $conn->fetchAll
    	(
			'SELECT g.nazwa as grupaNazwa, t.name as nameProwadzacy, t.surname as surnameProwadzacy, p.nazwa as przedmiotNazwa, z.id as zajecia_id
    			FROM grupa as g, teacher as t, przedmiot as p, zajecia as z
    		 WHERE g.id = z.grupa_id
    		   AND t.id = z.teacher_id
    		   AND p.id = z.przedmiot_id
    		   AND z.active = 1'
    	);
    	
    	$nieaktywneZajecia = $conn->fetchAll
    	(
    			'SELECT g.nazwa as grupaNazwa, t.name as nameProwadzacy, t.surname as surnameProwadzacy, p.nazwa as przedmiotNazwa, z.id as zajecia_id
    			FROM grupa as g, teacher as t, przedmiot as p, zajecia as z
    		 WHERE g.id = z.grupa_id
    		   AND t.id = z.teacher_id
    		   AND p.id = z.przedmiot_id
    		   AND z.active = 0'
		);
    	   	
    	return $this->render('admin/zajecia.html.twig',
    			array('zajecia' => $zajecia,
    				  'nieaktywneZajecia' => $nieaktywneZajecia,
    			      'przedmioty' => $przedmioty,
    				  'prowadzacy' => $prowadzacy,
    				  'grupa' => $grupa				
    			));
    }
    
    /**
     * @Route("/admin/dodajZajecie", name="admin_dodajZajecie")
     */
    public function dodajZajecie(Request $request)
    {
    	$conn = $this->get('database_connection');
    	
    	$grupa_id = $request->request->get('grupa_id');
    	$przedmiot_id = $request->request->get('przedmiot_id');	
    	$prowadzacy_id = $request->request->get('prowadzacy_id');
    	
    	$sql = sprintf('INSERT INTO zajecia SET grupa_id ="%s", przedmiot_id="%s", teacher_id="%s", active=1',$grupa_id, $przedmiot_id, $prowadzacy_id);
    	$conn->query($sql);
    		
    	$this->addFlash(
    			'notice',
    			'Dodano zajęcia!'
    			);
    	
    	return $this->redirectToRoute('admin_zajecia');
    }
    
    /**
     * @Route("/admin/zajeciaStudenci", name="admin_zajeciaStudenci")
     */
    public function zajeciaStudenci(Request $request)
    {
    	$conn = $this->get('database_connection');
    	
    	$zajecia_id = $request->request->get('zajecia_id');
    	$nameProwadzacy = $request->request->get('nameProwadzacy');
    	$surnameProwadzacy = $request->request->get('surnameProwadzacy');
    	$grupaNazwa = $request->request->get('grupaNazwa');
    	$przedmiotNazwa = $request->request->get('przedmiotNazwa');
    		
    	
    	$sql = sprintf
    	(
    		'SELECT zs.id as zajeciastudent_id, s.name as nameStudent, s.surname as surnameStudent, s.id as student_id
    		   FROM zajeciastudent zs,student s
    		  WHERE s.id = zs.student_id
    			AND zs.zajecia_id = "%s"',$zajecia_id
   		);	
    	$studenci = $conn->fetchAll($sql);
    	
  	
    	$sql = 'SELECT s.name, s.surname, s.id FROM student s'; 
		$max = sizeof($studenci);
		for($i=0;$i<$max;$i++)
		{
			if($i==0)
			{
				$sql = $sql." WHERE s.id !=".$studenci[$i]['student_id'];
			}
			else
			{
				$sql = $sql." AND s.id !=".$studenci[$i]['student_id'];
			}
		}
		$studenciKtorzyNie = $conn->fetchAll($sql);
    	 	
    	return $this->render('admin/zajeciaStudenci.html.twig',
    			array('studenci' => $studenci,
    				  'studenciKtorzyNie'=> $studenciKtorzyNie,
    				  'zajecia_id'=> $zajecia_id,
    				  'nameProwadzacy'=> $nameProwadzacy,
    				  'surnameProwadzacy'=> $surnameProwadzacy,
    				  'grupaNazwa'=> $grupaNazwa,
    			      'przedmiotNazwa'=> $przedmiotNazwa
    			));
    }
    
     /**
     * @Route("/admin/dodajZajecieStudenta", name="admin_dodajZajecieStudenta")
     */
    public function dodajZajecieStudenta(Request $request)
    {
    	$conn = $this->get('database_connection');
    	
    	$zajecia_id = $request->request->get('zajecia_id');
    	$student_id = $request->request->get('student_id');
    	
    	$sql = sprintf('INSERT INTO zajeciastudent SET zajecia_id="%s", student_id="%s"',$zajecia_id,$student_id);
    	$conn->query($sql);
    	
    	$this->addFlash(
    			'notice',
    			'Dodano studenta!'
    			);
    
		return $this->redirectToRoute('admin_zajeciaStudenci', [
				'request' => $request
		], 307);
    }
    
    
  
}
