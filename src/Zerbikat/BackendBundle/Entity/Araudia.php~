<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Araudia
 *
 * @ORM\Table(name="araudia", indexes={@ORM\Index(name="araumota_id_idx", columns={"araumota_id"})})
 * @ORM\Entity
 */
class Araudia
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;
    
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
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *          ERLAZIOAK
     */


    /**
     * @var \Zerbikat\BackendBundle\Entity\Araumota
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Araumota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="araumota_id", referencedColumnName="id")
     * })
     */
    private $araumota;

    public function __toString()
    {
        return $this->getKodea();
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
}
