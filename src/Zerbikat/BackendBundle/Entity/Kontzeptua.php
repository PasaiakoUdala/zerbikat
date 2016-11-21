<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Kontzeptua
 *
 * @ORM\Table(name="kontzeptua", indexes={@ORM\Index(name="azpiatala_id_idx", columns={"azpiatala_id"}), @ORM\Index(name="baldintza_id_idx", columns={"baldintza_id"}), @ORM\Index(name="kontzeptumota_id_idx", columns={"kontzeptumota_id"})})
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Kontzeptua
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
     * @ORM\Column(name="kontzeptuaeu", type="text", length=65535, nullable=true)
     */
    private $kontzeptuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="kontzeptuaes", type="text", length=65535, nullable=true)
     */
    private $kontzeptuaes;

    /**
     * @var string
     *
     * @ORM\Column(name="kopurua", type="string", length=50, nullable=true)
     */
    private $kopurua;

    /**
     * @var string
     *
     * @ORM\Column(name="unitatea", type="string", length=50, nullable=true)
     */
    private $unitatea;



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
     * @var \Zerbikat\BackendBundle\Entity\Kontzeptumota
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Kontzeptumota")
     * @ORM\JoinColumn(name="kontzeptumota_id", referencedColumnName="id",onDelete="SET NULL")
     *
     */
    private $kontzeptumota;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Baldintza
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Baldintza")
     * @ORM\JoinColumn(name="baldintza_id", referencedColumnName="id",onDelete="SET NULL")
     *
     */
    private $baldintza;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Azpiatala
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Azpiatala", inversedBy="kontzeptuak")
     * @ORM\JoinColumn(name="azpiatala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $azpiatala;


    /**
     *          TOSTRING
     */
    public function __toString()
    {
        return $this->getKodea() . " - " . $this->getKontzeptuaeu();
    }





    /**
     * Set kodea
     *
     * @param string $kodea
     * @return Kontzeptua
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
     * Set kontzeptuaeu
     *
     * @param string $kontzeptuaeu
     * @return Kontzeptua
     */
    public function setKontzeptuaeu($kontzeptuaeu)
    {
        $this->kontzeptuaeu = $kontzeptuaeu;

        return $this;
    }

    /**
     * Get kontzeptuaeu
     *
     * @return string 
     */
    public function getKontzeptuaeu()
    {
        return $this->kontzeptuaeu;
    }

    /**
     * Set kontzeptuaes
     *
     * @param string $kontzeptuaes
     * @return Kontzeptua
     */
    public function setKontzeptuaes($kontzeptuaes)
    {
        $this->kontzeptuaes = $kontzeptuaes;

        return $this;
    }

    /**
     * Get kontzeptuaes
     *
     * @return string 
     */
    public function getKontzeptuaes()
    {
        return $this->kontzeptuaes;
    }

    /**
     * Set kopurua
     *
     * @param string $kopurua
     * @return Kontzeptua
     */
    public function setKopurua($kopurua)
    {
        $this->kopurua = $kopurua;

        return $this;
    }

    /**
     * Get kopurua
     *
     * @return string 
     */
    public function getKopurua()
    {
        return $this->kopurua;
    }

    /**
     * Set unitatea
     *
     * @param string $unitatea
     * @return Kontzeptua
     */
    public function setUnitatea($unitatea)
    {
        $this->unitatea = $unitatea;

        return $this;
    }

    /**
     * Get unitatea
     *
     * @return string 
     */
    public function getUnitatea()
    {
        return $this->unitatea;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Kontzeptua
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
     * @return Kontzeptua
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
     * Set kontzeptumota
     *
     * @param \Zerbikat\BackendBundle\Entity\Kontzeptumota $kontzeptumota
     * @return Kontzeptua
     */
    public function setKontzeptumota(\Zerbikat\BackendBundle\Entity\Kontzeptumota $kontzeptumota = null)
    {
        $this->kontzeptumota = $kontzeptumota;

        return $this;
    }

    /**
     * Get kontzeptumota
     *
     * @return \Zerbikat\BackendBundle\Entity\Kontzeptumota 
     */
    public function getKontzeptumota()
    {
        return $this->kontzeptumota;
    }

    /**
     * Set baldintza
     *
     * @param \Zerbikat\BackendBundle\Entity\Baldintza $baldintza
     * @return Kontzeptua
     */
    public function setBaldintza(\Zerbikat\BackendBundle\Entity\Baldintza $baldintza = null)
    {
        $this->baldintza = $baldintza;

        return $this;
    }

    /**
     * Get baldintza
     *
     * @return \Zerbikat\BackendBundle\Entity\Baldintza 
     */
    public function getBaldintza()
    {
        return $this->baldintza;
    }

    /**
     * Set azpiatala
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpiatala $azpiatala
     * @return Kontzeptua
     */
    public function setAzpiatala(\Zerbikat\BackendBundle\Entity\Azpiatala $azpiatala = null)
    {
        $this->azpiatala = $azpiatala;

        return $this;
    }

    /**
     * Get azpiatala
     *
     * @return \Zerbikat\BackendBundle\Entity\Azpiatala 
     */
    public function getAzpiatala()
    {
        return $this->azpiatala;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     * @return Kontzeptua
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
