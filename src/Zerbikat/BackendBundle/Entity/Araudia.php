<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Araudia
 *
 * @ORM\Table(name="araudia", indexes={@ORM\Index(name="araumota_id_idx", columns={"araumota_id"})})
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Araudia
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
     * @ORM\Column(name="kodea", type="string", length=255, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="arauaeu", type="string", length=255, nullable=true)
     */
    private $arauaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="arauaes", type="string", length=255, nullable=true)
     */
    private $arauaes;

    /**
     * @var string
     *
     * @ORM\Column(name="estekaeu", type="string", length=255, nullable=true)
     */
    private $estekaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="estekaes", type="string", length=255, nullable=true)
     */
    private $estekaes;

    /**
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala", cascade={"remove"})
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;

    /**
     * @var fitxak[]
     *
     * @ORM\OneToMany(targetEntity="FitxaAraudia", mappedBy="araudia")
     */
    private $fitxak;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Araumota
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Araumota",inversedBy="araudiak")
     * @ORM\JoinColumn(name="araumota_id", referencedColumnName="id",onDelete="SET NULL")
     *
     */
    private $araumota;



    /**
     *      FUNTZIOAK
     */

    public function __toString()
    {
        return $this->getKodea()."-".$this->getArauaeu();
    }



    /**
     * Set kodea
     *
     * @param string $kodea
     *
     * @return Araudia
     */
    public function setKodea($kodea)
    {
        $this->kodea = $kodea;

        return $this;
    }

    /**
     * Get kodea
     *
     * @return string
     */
    public function getKodea()
    {
        return $this->kodea;
    }

    /**
     * Set arauaeu
     *
     * @param string $arauaeu
     *
     * @return Araudia
     */
    public function setArauaeu($arauaeu)
    {
        $this->arauaeu = $arauaeu;

        return $this;
    }

    /**
     * Get arauaeu
     *
     * @return string
     */
    public function getArauaeu()
    {
        return $this->arauaeu;
    }

    /**
     * Set arauaes
     *
     * @param string $arauaes
     *
     * @return Araudia
     */
    public function setArauaes($arauaes)
    {
        $this->arauaes = $arauaes;

        return $this;
    }

    /**
     * Get arauaes
     *
     * @return string
     */
    public function getArauaes()
    {
        return $this->arauaes;
    }

    /**
     * Set estekaeu
     *
     * @param string $estekaeu
     *
     * @return Araudia
     */
    public function setEstekaeu($estekaeu)
    {
        $this->estekaeu = $estekaeu;

        return $this;
    }

    /**
     * Get estekaeu
     *
     * @return string
     */
    public function getEstekaeu()
    {
        return $this->estekaeu;
    }

    /**
     * Set estekaes
     *
     * @param string $estekaes
     *
     * @return Araudia
     */
    public function setEstekaes($estekaes)
    {
        $this->estekaes = $estekaes;

        return $this;
    }

    /**
     * Get estekaes
     *
     * @return string
     */
    public function getEstekaes()
    {
        return $this->estekaes;
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
     * @return Araudia
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
     * Set araumota
     *
     * @param \Zerbikat\BackendBundle\Entity\Araumota $araumota
     *
     * @return Araudia
     */
    public function setAraumota(\Zerbikat\BackendBundle\Entity\Araumota $araumota = null)
    {
        $this->araumota = $araumota;

        return $this;
    }

    /**
     * Get araumota
     *
     * @return \Zerbikat\BackendBundle\Entity\Araumota
     */
    public function getAraumota()
    {
        return $this->araumota;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fitxak = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\FitxaAraudia $fitxak
     *
     * @return Araudia
     */
    public function addFitxak(\Zerbikat\BackendBundle\Entity\FitxaAraudia $fitxak)
    {
        $this->fitxak[] = $fitxak;

        return $this;
    }

    /**
     * Remove fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\FitxaAraudia $fitxak
     */
    public function removeFitxak(\Zerbikat\BackendBundle\Entity\FitxaAraudia $fitxak)
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
