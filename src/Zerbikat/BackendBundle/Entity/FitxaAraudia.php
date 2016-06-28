<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * FitxaAraudia
 *
 * @ORM\Table(name="fitxa_araudia", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="araudia_id_idx", columns={"araudia_id"})})
 * @ORM\Entity
 */
class FitxaAraudia
{
    /**
     * @var string
     *
     * @ORM\Column(name="atalaeu", type="string", length=50, nullable=true)
     */
    private $atalaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="atalaes", type="string", length=50, nullable=true)
     */
    private $atalaes;

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
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;
    
    
    /**
     * @var \Zerbikat\BackendBundle\Entity\Fitxa
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Fitxa",inversedBy="araudiak")
     * @ORM\JoinColumn(name="fitxa_id", referencedColumnName="id",onDelete="CASCADE")
     * 
     */
    private $fitxa;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Araudia
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Araudia",inversedBy="fitxak")
     * @ORM\JoinColumn(name="araudia_id", referencedColumnName="id",onDelete="CASCADE")
     * 
     */
    private $araudia;

    /**
     *          TOSTRING
     */

    public function __toString()
    {
        return $this->araudia->getKodea()."-".$this->araudia->getArauaeu();
    }



    /**
     * Set atalaeu
     *
     * @param string $atalaeu
     *
     * @return FitxaAraudia
     */
    public function setAtalaeu($atalaeu)
    {
        $this->atalaeu = $atalaeu;

        return $this;
    }

    /**
     * Get atalaeu
     *
     * @return string
     */
    public function getAtalaeu()
    {
        return $this->atalaeu;
    }

    /**
     * Set atalaes
     *
     * @param string $atalaes
     *
     * @return FitxaAraudia
     */
    public function setAtalaes($atalaes)
    {
        $this->atalaes = $atalaes;

        return $this;
    }

    /**
     * Get atalaes
     *
     * @return string
     */
    public function getAtalaes()
    {
        return $this->atalaes;
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
     * @return FitxaAraudia
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
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     *
     * @return FitxaAraudia
     */
    public function setFitxa(\Zerbikat\BackendBundle\Entity\Fitxa $fitxa = null)
    {
        $this->fitxa = $fitxa;

        return $this;
    }

    /**
     * Get fitxa
     *
     * @return \Zerbikat\BackendBundle\Entity\Fitxa
     */
    public function getFitxa()
    {
        return $this->fitxa;
    }

    /**
     * Set araudia
     *
     * @param \Zerbikat\BackendBundle\Entity\Araudia $araudia
     *
     * @return FitxaAraudia
     */
    public function setAraudia(\Zerbikat\BackendBundle\Entity\Araudia $araudia = null)
    {
        $this->araudia = $araudia;

        return $this;
    }

    /**
     * Get araudia
     *
     * @return \Zerbikat\BackendBundle\Entity\Araudia
     */
    public function getAraudia()
    {
        return $this->araudia;
    }
}
