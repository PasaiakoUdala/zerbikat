<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Azpiatala
 *
 * @ORM\Table(name="azpiatala", indexes={@ORM\Index(name="atala_id_idx", columns={"atala_id"})})
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Azpiatala
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
     * @ORM\Column(name="kodea", type="string", length=9, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="izenburuaeu", type="string", length=255, nullable=true)
     */
    private $izenburuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="izenburuaes", type="string", length=255, nullable=true)
     */
    private $izenburuaes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;



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
     * @var \Zerbikat\BackendBundle\Entity\Atala
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Atala")
     * @ORM\JoinColumn(name="atala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $atala;

    /**
     * @var kontzeptuak[]
     *
     * @ORM\OneToMany(targetEntity="Kontzeptua", mappedBy="azpiatala")
     */
    private $kontzeptuak;

    /**
     * @var parrafoak[]
     *
     * @ORM\OneToMany(targetEntity="Azpiatalaparrafoa", mappedBy="azpiatala")
     */
    private $parrafoak;

    /**
     * @var fitxak[]
     *
     * @ORM\ManyToMany(targetEntity="Fitxa",mappedBy="azpiatalak")
     */
    private $fitxak;


    /**
     *          TOSTRING
     */
    public function __toString()
    {
        return
            $this->getAtala()->getOrdenantza()->getKodea().".".$this->getAtala()->getKodea().".".$this->getKodea()."-".$this->getIzenburuaeu();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kontzeptuak = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parrafoak = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fitxak = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set kodea
     *
     * @param string $kodea
     *
     * @return Azpiatala
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
     * Set izenburuaeu
     *
     * @param string $izenburuaeu
     *
     * @return Azpiatala
     */
    public function setIzenburuaeu($izenburuaeu)
    {
        $this->izenburuaeu = $izenburuaeu;

        return $this;
    }

    /**
     * Get izenburuaeu
     *
     * @return string
     */
    public function getIzenburuaeu()
    {
        return $this->izenburuaeu;
    }

    /**
     * Set izenburuaes
     *
     * @param string $izenburuaes
     *
     * @return Azpiatala
     */
    public function setIzenburuaes($izenburuaes)
    {
        $this->izenburuaes = $izenburuaes;

        return $this;
    }

    /**
     * Get izenburuaes
     *
     * @return string
     */
    public function getIzenburuaes()
    {
        return $this->izenburuaes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Azpiatala
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Azpiatala
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * @return Azpiatala
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
     * Set atala
     *
     * @param \Zerbikat\BackendBundle\Entity\Atala $atala
     *
     * @return Azpiatala
     */
    public function setAtala(\Zerbikat\BackendBundle\Entity\Atala $atala = null)
    {
        $this->atala = $atala;

        return $this;
    }

    /**
     * Get atala
     *
     * @return \Zerbikat\BackendBundle\Entity\Atala
     */
    public function getAtala()
    {
        return $this->atala;
    }

    /**
     * Add kontzeptuak
     *
     * @param \Zerbikat\BackendBundle\Entity\Kontzeptua $kontzeptuak
     *
     * @return Azpiatala
     */
    public function addKontzeptuak(\Zerbikat\BackendBundle\Entity\Kontzeptua $kontzeptuak)
    {
        $this->kontzeptuak[] = $kontzeptuak;

        return $this;
    }

    /**
     * Remove kontzeptuak
     *
     * @param \Zerbikat\BackendBundle\Entity\Kontzeptua $kontzeptuak
     */
    public function removeKontzeptuak(\Zerbikat\BackendBundle\Entity\Kontzeptua $kontzeptuak)
    {
        $this->kontzeptuak->removeElement($kontzeptuak);
    }

    /**
     * Get kontzeptuak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKontzeptuak()
    {
        return $this->kontzeptuak;
    }

    /**
     * Add parrafoak
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpiatalaparrafoa $parrafoak
     *
     * @return Azpiatala
     */
    public function addParrafoak(\Zerbikat\BackendBundle\Entity\Azpiatalaparrafoa $parrafoak)
    {
        $this->parrafoak[] = $parrafoak;

        return $this;
    }

    /**
     * Remove parrafoak
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpiatalaparrafoa $parrafoak
     */
    public function removeParrafoak(\Zerbikat\BackendBundle\Entity\Azpiatalaparrafoa $parrafoak)
    {
        $this->parrafoak->removeElement($parrafoak);
    }

    /**
     * Get parrafoak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParrafoak()
    {
        return $this->parrafoak;
    }

    /**
     * Add fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxak
     *
     * @return Azpiatala
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
