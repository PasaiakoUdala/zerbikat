<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Datuenbabesa
 *
 * @ORM\Table(name="datuenbabesa")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Datuenbabesa
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
     * @ORM\Column(name="izenaeu", type="string", length=255, nullable=true)
     */
    private $izenaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="izenaes", type="string", length=255, nullable=true)
     */
    private $izenaes;

    /**
     * @var string
     *
     * @ORM\Column(name="xedeaeu", type="text", length=65535, nullable=true)
     */
    private $xedeaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="xedeaes", type="text", length=65535, nullable=true)
     */
    private $xedeaes;

    /**
     * @var string
     *
     * @ORM\Column(name="maila", type="string", length=45, nullable=true)
     */
    private $maila;

    /**
     * @var string
     *
     * @ORM\Column(name="kodea", type="string", length=45, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="lagapenakeu", type="string", length=255, nullable=true)
     */
    private $lagapenakeu;

    /**
     * @var string
     *
     * @ORM\Column(name="lagapenakes", type="string", length=255, nullable=true)
     */
    private $lagapenakes;


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
     * Set izenaeu
     *
     * @param string $izenaeu
     * @return Datuenbabesa
     */
    public function setIzenaeu($izenaeu)
    {
        $this->izenaeu = $izenaeu;

        return $this;
    }

    /**
     * Get izenaeu
     *
     * @return string 
     */
    public function getIzenaeu()
    {
        return $this->izenaeu;
    }

    /**
     * Set izenaes
     *
     * @param string $izenaes
     * @return Datuenbabesa
     */
    public function setIzenaes($izenaes)
    {
        $this->izenaes = $izenaes;

        return $this;
    }

    /**
     * Get izenaes
     *
     * @return string 
     */
    public function getIzenaes()
    {
        return $this->izenaes;
    }

    /**
     * Set xedeaeu
     *
     * @param string $xedeaeu
     * @return Datuenbabesa
     */
    public function setXedeaeu($xedeaeu)
    {
        $this->xedeaeu = $xedeaeu;

        return $this;
    }

    /**
     * Get xedeaeu
     *
     * @return string 
     */
    public function getXedeaeu()
    {
        return $this->xedeaeu;
    }

    /**
     * Set xedeaes
     *
     * @param string $xedeaes
     * @return Datuenbabesa
     */
    public function setXedeaes($xedeaes)
    {
        $this->xedeaes = $xedeaes;

        return $this;
    }

    /**
     * Get xedeaes
     *
     * @return string 
     */
    public function getXedeaes()
    {
        return $this->xedeaes;
    }

    /**
     * Set maila
     *
     * @param string $maila
     * @return Datuenbabesa
     */
    public function setMaila($maila)
    {
        $this->maila = $maila;

        return $this;
    }

    /**
     * Get maila
     *
     * @return string 
     */
    public function getMaila()
    {
        return $this->maila;
    }

    /**
     * Set kodea
     *
     * @param string $kodea
     * @return Datuenbabesa
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
     * Set lagapenakeu
     *
     * @param string $lagapenakeu
     * @return Datuenbabesa
     */
    public function setLagapenakeu($lagapenakeu)
    {
        $this->lagapenakeu = $lagapenakeu;

        return $this;
    }

    /**
     * Get lagapenakeu
     *
     * @return string 
     */
    public function getLagapenakeu()
    {
        return $this->lagapenakeu;
    }

    /**
     * Set lagapenakes
     *
     * @param string $lagapenakes
     * @return Datuenbabesa
     */
    public function setLagapenakes($lagapenakes)
    {
        $this->lagapenakes = $lagapenakes;

        return $this;
    }

    /**
     * Get lagapenakes
     *
     * @return string 
     */
    public function getLagapenakes()
    {
        return $this->lagapenakes;
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

    public function __toString()
    {
        return (string) $this->getIzenaeu();
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     * @return Datuenbabesa
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
}
