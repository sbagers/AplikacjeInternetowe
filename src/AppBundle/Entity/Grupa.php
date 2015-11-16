<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="grupa")
 */
class Grupa
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
     * @ORM\ManyToOne(targetEntity="FormaZajec", inversedBy="grupa")
     * @ORM\JoinColumn(name="formazajec_id", referencedColumnName="id")
     */
    protected $formazajec;
   
    /**
     * @ORM\OneToMany(targetEntity="Zajecia", mappedBy="grupa")
     */
    protected $zajecia;

  
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
     * @return Grupa
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
     * Set formazajec
     *
     * @param \AppBundle\Entity\FormaZajec $formazajec
     *
     * @return Grupa
     */
    public function setFormazajec(\AppBundle\Entity\FormaZajec $formazajec = null)
    {
        $this->formazajec = $formazajec;

        return $this;
    }

    /**
     * Get formazajec
     *
     * @return \AppBundle\Entity\FormaZajec
     */
    public function getFormazajec()
    {
        return $this->formazajec;
    }

    /**
     * Add zajecium
     *
     * @param \AppBundle\Entity\Zajecia $zajecium
     *
     * @return Grupa
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
}
