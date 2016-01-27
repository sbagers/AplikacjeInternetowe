<?php 
// src/AppBundle/Entity/Student.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class Student implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $surname;
    
    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
    /**
     * @ORM\OneToMany(targetEntity="ZajeciaStudent", mappedBy="student")
     */
    protected $zajeciastudent;
    
    
    public function __construct()
    {
    	$this->isActive = true;
    	// may not be needed, see section on salt below
    	// $this->salt = md5(uniqid(null, true));
    }
    
    public function getUsername()
    {
    	return $this->login;
    }
    
    public function getSalt()
    {
    	// you *may* need a real salt depending on your encoder
    	// see section on salt below
    	return null;
    }
    
    public function getPassword()
    {
    	return $this->password;
    }
    
    public function getRoles()
    {
    	return array('ROLE_STUDENT');
    }
    
    public function eraseCredentials()
    {
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
    	return serialize(array(
    			$this->id,
    			$this->login,
    			$this->password,
    			$this->active,
    			// see section on salt below
    			// $this->salt,
    	));
    }
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
    	list (
    			$this->id,
    			$this->login,
    			$this->password,
    			$this->active,
    			// see section on salt below
    			// $this->salt
    			) = unserialize($serialized);
    }
    
    public function isAccountNonExpired()
    {
    	return true;
    }
    
    public function isAccountNonLocked()
    {
    	return true;
    }
    
    public function isCredentialsNonExpired()
    {
    	return true;
    }
    
    public function isEnabled()
    {
    	return $this->active;
    }
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Student
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Student
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Student
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Add zajeciastudent
     *
     * @param \AppBundle\Entity\ZajeciaStudent $zajeciastudent
     *
     * @return Student
     */
    public function addZajeciastudent(\AppBundle\Entity\ZajeciaStudent $zajeciastudent)
    {
        $this->zajeciastudent[] = $zajeciastudent;

        return $this;
    }

    /**
     * Remove zajeciastudent
     *
     * @param \AppBundle\Entity\ZajeciaStudent $zajeciastudent
     */
    public function removeZajeciastudent(\AppBundle\Entity\ZajeciaStudent $zajeciastudent)
    {
        $this->zajeciastudent->removeElement($zajeciastudent);
    }

    /**
     * Get zajeciastudent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZajeciastudent()
    {
        return $this->zajeciastudent;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Student
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Student
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
