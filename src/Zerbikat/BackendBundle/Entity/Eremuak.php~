<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eremuak
 *
 * @ORM\Table(name="eremuak")
 * @ORM\Entity
 */
class Eremuak
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @ORM\OneToOne(targetEntity="Udala") */
    private $udala;

    /**
     * @var oharraktext
     *
     * @ORM\Column(name="oharraktext", type="boolean", nullable=true)
     */
    private $oharraktext;

    /**
     * @var oharraklabeleu
     *
     * @ORM\Column(name="oharraklabeleu", type="string", length=255, nullable=true)
     */
    private $oharraklabeleu;

    /**
     * @var oharraklabeles
     *
     * @ORM\Column(name="oharraklabeles", type="string", length=255, nullable=true)
     */
    private $oharraklabeles;





    /**
     *
     *      FUBTZIOAK
     *
     */


    
    /**
     * Set oharraktext
     *
     * @param boolean $oharraktext
     *
     * @return Eremuak
     */
    public function setOharraktext($oharraktext)
    {
        $this->oharraktext = $oharraktext;

        return $this;
    }

    /**
     * Get oharraktext
     *
     * @return boolean
     */
    public function getOharraktext()
    {
        return $this->oharraktext;
    }

    /**
     * Set oharraklabeleu
     *
     * @param string $oharraklabeleu
     *
     * @return Eremuak
     */
    public function setOharraklabeleu($oharraklabeleu)
    {
        $this->oharraklabeleu = $oharraklabeleu;

        return $this;
    }

    /**
     * Get oharraklabeleu
     *
     * @return string
     */
    public function getOharraklabeleu()
    {
        return $this->oharraklabeleu;
    }

    /**
     * Set oharraklabeles
     *
     * @param string $oharraklabeles
     *
     * @return Eremuak
     */
    public function setOharraklabeles($oharraklabeles)
    {
        $this->oharraklabeles = $oharraklabeles;

        return $this;
    }

    /**
     * Get oharraklabeles
     *
     * @return string
     */
    public function getOharraklabeles()
    {
        return $this->oharraklabeles;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return Eremuak
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
