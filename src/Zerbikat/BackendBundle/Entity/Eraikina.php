<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eraikina
 *
 * @ORM\Table(name="eraikina", indexes={@ORM\Index(name="barrutia_id_idx", columns={"barrutia_id"})})
 * @ORM\Entity
 */
class Eraikina
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
     * @var float
     *
     * @ORM\Column(name="longitudea", type="float", precision=18, scale=6, nullable=false)
     */
    private $longitudea;

    /**
     * @var float
     *
     * @ORM\Column(name="latitudea", type="float", precision=18, scale=6, nullable=false)
     */
    private $latitudea;

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
     * @return Eraikina
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
     * Set longitudea
     *
     * @param float $longitudea
     * @return Eraikina
     */
    public function setLongitudea($longitudea)
    {
        $this->longitudea = $longitudea;

        return $this;
    }

    /**
     * Get longitudea
     *
     * @return float 
     */
    public function getLongitudea()
    {
        return $this->longitudea;
    }

    /**
     * Set latitudea
     *
     * @param float $latitudea
     * @return Eraikina
     */
    public function setLatitudea($latitudea)
    {
        $this->latitudea = $latitudea;

        return $this;
    }

    /**
     * Get latitudea
     *
     * @return float 
     */
    public function getLatitudea()
    {
        return $this->latitudea;
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
     * @return Eraikina
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
     * @return Eraikina
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
