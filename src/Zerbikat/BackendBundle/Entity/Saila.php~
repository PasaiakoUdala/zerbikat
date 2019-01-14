<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;
use Zerbikat\BackendBundle\Entity\Azpisaila;
use Zerbikat\BackendBundle\Entity\Udala;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Saila
 *
 * @ORM\Table(name="saila")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 * @ExclusionPolicy("all")
 */
class Saila
{
    /**
     * @var integer
     * @Expose
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="origenid", type="bigint")
     */
    private $origenid;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="kodea", type="string", length=10, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="sailaeu", type="string", length=255, nullable=true)
     */
    private $sailaeu;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="sailaes", type="string", length=255, nullable=true)
     */
    private $sailaes;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="arduraduna", type="string", length=255, nullable=true)
     */
    private $arduraduna;



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
     * @var azpisailak[]
     * @Expose
     *
     * @ORM\OneToMany(targetEntity="Azpisaila", mappedBy="saila")
     */
    private $azpisailak;


    /**
     *          TOSTRING
     */
    public function __toString()
    {
        return (string) $this->getSailaeu();
    }


    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->azpisailak = new ArrayCollection();
    }

    /**
     * Set kodea
     *
     * @param string $kodea
     *
     * @return Saila
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
     * Set sailaeu
     *
     * @param string $sailaeu
     *
     * @return Saila
     */
    public function setSailaeu($sailaeu)
    {
        $this->sailaeu = $sailaeu;

        return $this;
    }

    /**
     * Get sailaeu
     *
     * @return string
     */
    public function getSailaeu()
    {
        return $this->sailaeu;
    }

    /**
     * Set sailaes
     *
     * @param string $sailaes
     *
     * @return Saila
     */
    public function setSailaes($sailaes)
    {
        $this->sailaes = $sailaes;

        return $this;
    }

    /**
     * Get sailaes
     *
     * @return string
     */
    public function getSailaes()
    {
        return $this->sailaes;
    }

    /**
     * Set arduraduna
     *
     * @param string $arduraduna
     *
     * @return Saila
     */
    public function setArduraduna($arduraduna)
    {
        $this->arduraduna = $arduraduna;

        return $this;
    }

    /**
     * Get arduraduna
     *
     * @return string
     */
    public function getArduraduna()
    {
        return $this->arduraduna;
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
     * @param Udala $udala
     *
     * @return Saila
     */
    public function setUdala( Udala $udala = null)
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * Get udala
     *
     * @return Udala
     */
    public function getUdala()
    {
        return $this->udala;
    }

    /**
     * Add azpisailak
     *
     * @param Azpisaila $azpisailak
     *
     * @return Saila
     */
    public function addAzpisailak( Azpisaila $azpisailak)
    {
        $this->azpisailak[] = $azpisailak;

        return $this;
    }

    /**
     * Remove azpisailak
     *
     * @param Azpisaila $azpisailak
     */
    public function removeAzpisailak( Azpisaila $azpisailak)
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
     * Set origenid
     *
     * @param integer $origenid
     *
     * @return Saila
     */
    public function setOrigenid($origenid)
    {
        $this->origenid = $origenid;

        return $this;
    }

    /**
     * Get origenid
     *
     * @return integer
     */
    public function getOrigenid()
    {
        return $this->origenid;
    }
}
