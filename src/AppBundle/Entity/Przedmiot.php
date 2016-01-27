<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="przedmiot")
 */
class Przedmiot
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nazwa;
    
    /**
     * @ORM\OneToMany(targetEntity="Zajecia", mappedBy="przedmiot")
     */
    protected $zajecia;
    
    /**
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zajecia = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Przedmiot
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Add zajecium
     *
     * @param \AppBundle\Entity\Zajecia $zajecium
     *
     * @return Przedmiot
     */
    public function addZajecium(\AppBundle\Entity\Zajecia $zajecium)
    {
        $this->zajecia[] = $zajecium;

        return $this;
    }

    /**
     * Remove zajecium
     *
     * @param \AppBundle\Entity\Zajecia $zajecium
     */
    public function removeZajecium(\AppBundle\Entity\Zajecia $zajecium)
    {
        $this->zajecia->removeElement($zajecium);
    }

    /**
     * Get zajecia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZajecia()
    {
        return $this->zajecia;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Przedmiot
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
