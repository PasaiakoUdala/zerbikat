<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Familia
 *
 * @ORM\Table(name="familia")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Familia
{

    /**
     * @var integer
     * @Expose
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

    /**
     *
     * @var string
     * @Expose
     *
     * @ORM\Column(name="familiaeu", type="string", length=255, nullable=true)
     */
    private $familiaeu;


    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="familiaes", type="string", length=255, nullable=true)
     */
    private $familiaes;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="deskribapenaeu", type="string", length=255, nullable=true)
     */
    private $deskribapenaeu;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="deskribapenaes", type="string", length=255, nullable=true)
     */
    private $deskribapenaes;





    public function __toString()
    {
        return $this->getFamiliaeu();
    }


    /**
     * 
     *      ERLAZIOAK
     * 
     */

    /**
     * @var fitxak[]
     *
     * @ORM\ManyToMany(targetEntity="Fitxa", mappedBy="familiak", cascade={"remove"})
     */
    private $fitxak;
    
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fitxak = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set familiaeu
     *
     * @param string $familiaeu
     *
     * @return Familia
     */
    public function setFamiliaeu($familiaeu)
    {
        $this->familiaeu = $familiaeu;

        return $this;
    }

    /**
     * Get familiaeu
     *
     * @return string
     */
    public function getFamiliaeu()
    {
        return $this->familiaeu;
    }

    /**
     * Set familiaes
     *
     * @param string $familiaes
     *
     * @return Familia
     */
    public function setFamiliaes($familiaes)
    {
        $this->familiaes = $familiaes;

        return $this;
    }

    /**
     * Get familiaes
     *
     * @return string
     */
    public function getFamiliaes()
    {
        return $this->familiaes;
    }

    /**
     * Set deskribapenaeu
     *
     * @param string $deskribapenaeu
     *
     * @return Familia
     */
    public function setDeskribapenaeu($deskribapenaeu)
    {
        $this->deskribapenaeu = $deskribapenaeu;

        return $this;
    }

    /**
     * Get deskribapenaeu
     *
     * @return string
     */
    public function getDeskribapenaeu()
    {
        return $this->deskribapenaeu;
    }

    /**
     * Set deskribapenaes
     *
     * @param string $deskribapenaes
     *
     * @return Familia
     */
    public function setDeskribapenaes($deskribapenaes)
    {
        $this->deskribapenaes = $deskribapenaes;

        return $this;
    }

    /**
     * Get deskribapenaes
     *
     * @return string
     */
    public function getDeskribapenaes()
    {
        return $this->deskribapenaes;
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
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return Familia
     */
    public function setUdala(\Zerbikat\BackendBundle\Entity\Udala $udala = null)
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * Get udala
     *
     * @return \Zerbikat\BackendBundle\Entity\Udala
     */
    public function getUdala()
    {
        return $this->udala;
    }

    /**
     * Add fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxak
     *
     * @return Familia
     */
    public function addFitxak(\Zerbikat\BackendBundle\Entity\Fitxa $fitxak)
    {
        $this->fitxak[] = $fitxak;

        return $this;
    }

    /**
     * Remove fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxak
     */
    public function removeFitxak(\Zerbikat\BackendBundle\Entity\Fitxa $fitxak)
    {
        $this->fitxak->removeElement($fitxak);
    }

    /**
     * Get fitxak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFitxak()
    {
        return $this->fitxak;
    }
}
