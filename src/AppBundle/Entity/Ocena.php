<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ocena")
 */
class Ocena
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $wartosc;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $komentarz;
    
    /**
     * @ORM\ManyToOne(targetEntity="ZajeciaStudent", inversedBy="ocena")
     * @ORM\JoinColumn(name="zajeciastudent_id", referencedColumnName="id")
     */
    protected $zajeciastudent;
 

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
     * Set wartosc
     *
     * @param integer $wartosc
     *
     * @return Ocena
     */
    public function setWartosc($wartosc)
    {
        $this->wartosc = $wartosc;

        return $this;
    }

    /**
     * Get wartosc
     *
     * @return integer
     */
    public function getWartosc()
    {
        return $this->wartosc;
    }

    /**
     * Set komentarz
     *
     * @param string $komentarz
     *
     * @return Ocena
     */
    public function setKomentarz($komentarz)
    {
        $this->komentarz = $komentarz;

        return $this;
    }

    /**
     * Get komentarz
     *
     * @return string
     */
    public function getKomentarz()
    {
        return $this->komentarz;
    }

    /**
     * Set zajeciastudent
     *
     * @param \AppBundle\Entity\ZajeciaStudent $zajeciastudent
     *
     * @return Ocena
     */
    public function setZajeciastudent(\AppBundle\Entity\ZajeciaStudent $zajeciastudent = null)
    {
        $this->zajeciastudent = $zajeciastudent;

        return $this;
    }

    /**
     * Get zajeciastudent
     *
     * @return \AppBundle\Entity\ZajeciaStudent
     */
    public function getZajeciastudent()
    {
        return $this->zajeciastudent;
    }
}
