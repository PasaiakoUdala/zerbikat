<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Saila
 *
 * @ORM\Table(name="saila")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Saila
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
     * @ORM\Column(name="kodea", type="string", length=10, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="sailaeu", type="string", length=255, nullable=true)
     */
    private $sailaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="sailaes", type="string", length=255, nullable=true)
     */
    private $sailaes;

    /**
     * @var string
     *
     * @ORM\Column(name="arduraduna", type="string", length=255, nullable=true)
     */
    private $arduraduna;



    /**
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala", cascade={"remove"})
     *
     */
    private $udala;
    
    /**
     * @var azpisailak[]
     *
     * @ORM\OneToMany(targetEntity="Azpisaila", mappedBy="saila", cascade={"remove"})
     */
    private $azpisailak;


    public function __toString()
    {
        return $this->getSailaeu();
    }


    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->azpisailak = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return Saila
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
     * Add azpisailak
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpisaila $azpisailak
     *
     * @return Saila
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
}
