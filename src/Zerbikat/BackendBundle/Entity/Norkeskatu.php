<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Norkeskatu
 *
 * @ORM\Table(name="norkeskatu")
 * @ORM\Entity
 */
class Norkeskatu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="norkeu", type="string", length=255, nullable=true)
     */
    private $norkeu;

    /**
     * @var string
     *
     * @ORM\Column(name="norkes", type="string", length=255, nullable=true)
     */
    private $norkes;




    /**
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;
    
    /**
     * @var fitxak[]
     *
     * @ORM\ManyToMany(targetEntity="Fitxa",mappedBy="norkeskatuak", cascade="persist"))
     */
    private $fitxak;



    /**
     *          TOSTRING
     */
    public function __toString()
    {
        return (string) $this->getNorkeu();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fitxak = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set norkeu
     *
     * @param string $norkeu
     *
     * @return Norkeskatu
     */
    public function setNorkeu($norkeu)
    {
        $this->norkeu = $norkeu;

        return $this;
    }

    /**
     * Get norkeu
     *
     * @return string
     */
    public function getNorkeu()
    {
        return $this->norkeu;
    }

    /**
     * Set norkes
     *
     * @param string $norkes
     *
     * @return Norkeskatu
     */
    public function setNorkes($norkes)
    {
        $this->norkes = $norkes;

        return $this;
    }

    /**
     * Get norkes
     *
     * @return string
     */
    public function getNorkes()
    {
        return $this->norkes;
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
     * @return Norkeskatu
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
     * @return Norkeskatu
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
