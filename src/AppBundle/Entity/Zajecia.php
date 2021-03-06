<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="zajecia")
 */
class Zajecia
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Grupa", inversedBy="zajecia")
     * @ORM\JoinColumn(name="grupa_id", referencedColumnName="id")
     */
    protected $grupa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Przedmiot", inversedBy="zajecia")
     * @ORM\JoinColumn(name="przedmiot_id", referencedColumnName="id")
     */
    protected $przedmiot;
    
    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="zajecia")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
     */
    protected $teacher;
    
    /**
     * @ORM\OneToMany(targetEntity="ZajeciaStudent", mappedBy="zajecia")
     */
    protected $zajeciastudent;
    
    /**
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;
    
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zajeciastudent = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set grupa
     *
     * @param \AppBundle\Entity\Grupa $grupa
     *
     * @return Zajecia
     */
    public function setGrupa(\AppBundle\Entity\Grupa $grupa = null)
    {
        $this->grupa = $grupa;

        return $this;
    }

    /**
     * Get grupa
     *
     * @return \AppBundle\Entity\Grupa
     */
    public function getGrupa()
    {
        return $this->grupa;
    }

    /**
     * Set przedmiot
     *
     * @param \AppBundle\Entity\Przedmiot $przedmiot
     *
     * @return Zajecia
     */
    public function setPrzedmiot(\AppBundle\Entity\Przedmiot $przedmiot = null)
    {
        $this->przedmiot = $przedmiot;

        return $this;
    }

    /**
     * Get przedmiot
     *
     * @return \AppBundle\Entity\Przedmiot
     */
    public function getPrzedmiot()
    {
        return $this->przedmiot;
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\Teacher $teacher
     *
     * @return Zajecia
     */
    public function setTeacher(\AppBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Add zajeciastudent
     *
     * @param \AppBundle\Entity\ZajeciaStudent $zajeciastudent
     *
     * @return Zajecia
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Zajecia
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
