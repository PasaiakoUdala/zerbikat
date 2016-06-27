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
     * @var \Zerbikat\BackendBundle\Entity\Barrutia
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Barrutia", cascade={"remove"})
     * @ORM\JoinColumn(name="barrutia_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $barrutia;


    /**
     * @var azpisailak[]
     *
     * @ORM\OneToMany(targetEntity="Azpisaila", mappedBy="kalea")
     */
    private $azpisailak;

    /**
     * @var kanalak[]
     *
     * @ORM\OneToMany(targetEntity="Kanala", mappedBy="kalea")
     */
    private $kanalak;


    /**
     *          FUNTZIOAK
     */

    /**
     * @return string
     */

    public function __toString()
    {
        return $this->getIzena();
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->azpisailak = new \Doctrine\Common\Collections\ArrayCollection();
        $this->kanalak = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set izena
     *
     * @param string $izena
     *
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
     *
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
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
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

    /**
     * Set barrutia
     *
     * @param \Zerbikat\BackendBundle\Entity\Barrutia $barrutia
     *
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
     * Add azpisailak
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpisaila $azpisailak
     *
     * @return Kalea
     */
    public function addAzpisailak(\Zerbikat\BackendBundle\Entity\Azpisaila $azpisailak)
    {
        $this->azpisailak[] = $azpisailak;

        return $this;
    }

    /**
     * Remove azpisailak
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpisaila $azpisailak
     */
    public function removeAzpisailak(\Zerbikat\BackendBundle\Entity\Azpisaila $azpisailak)
    {
        $this->azpisailak->removeElement($azpisailak);
    }

    /**
     * Get azpisailak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAzpisailak()
    {
        return $this->azpisailak;
    }

    /**
     * Add kanalak
     *
     * @param \Zerbikat\BackendBundle\Entity\Kanala $kanalak
     *
     * @return Kalea
     */
    public function addKanalak(\Zerbikat\BackendBundle\Entity\Kanala $kanalak)
    {
        $this->kanalak[] = $kanalak;

        return $this;
    }

    /**
     * Remove kanalak
     *
     * @param \Zerbikat\BackendBundle\Entity\Kanala $kanalak
     */
    public function removeKanalak(\Zerbikat\BackendBundle\Entity\Kanala $kanalak)
    {
        $this->kanalak->removeElement($kanalak);
    }

    /**
     * Get kanalak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKanalak()
    {
        return $this->kanalak;
    }
}
