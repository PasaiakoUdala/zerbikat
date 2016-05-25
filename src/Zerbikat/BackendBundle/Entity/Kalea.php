<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kalea
 *
 * @ORM\Table(name="kalea", uniqueConstraints={@ORM\UniqueConstraint(name="izena", columns={"izena"})}, indexes={@ORM\Index(name="barrutia_id_idx", columns={"barrutia_id"})})
 * @ORM\Entity
 */
class Kalea
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

    /**
     * @var string
     *
     * @ORM\Column(name="izena", type="string", length=255, nullable=false)
     */
    private $izena;

    /**
     * @var string
     *
     * @ORM\Column(name="google", type="string", length=255, nullable=true)
     */
    private $google;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Barrutia
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Barrutia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="barrutia_id", referencedColumnName="id")
     * })
     */
    private $barrutia;



    /**
     * Set izena
     *
     * @param string $izena
     * @return Kalea
     */
    public function setIzena($izena)
    {
        $this->izena = $izena;

        return $this;
    }

    /**
     * Get izena
     *
     * @return string 
     */
    public function getIzena()
    {
        return $this->izena;
    }

    /**
     * Set google
     *
     * @param string $google
     * @return Kalea
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return string 
     */
    public function getGoogle()
    {
        return $this->google;
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
     * Set barrutia
     *
     * @param \Zerbikat\BackendBundle\Entity\Barrutia $barrutia
     * @return Kalea
     */
    public function setBarrutia(\Zerbikat\BackendBundle\Entity\Barrutia $barrutia = null)
    {
        $this->barrutia = $barrutia;

        return $this;
    }

    /**
     * Get barrutia
     *
     * @return \Zerbikat\BackendBundle\Entity\Barrutia 
     */
    public function getBarrutia()
    {
        return $this->barrutia;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     * @return Kalea
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
