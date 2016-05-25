<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Saila
 *
 * @ORM\Table(name="saila")
 * @ORM\Entity
 */
class Saila
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

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
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set kodea
     *
     * @param string $kodea
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
}
