<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tramitea
 *
 * @ORM\Table(name="tramitea")
 * @ORM\Entity
 */
class Tramitea
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

    /**
     * @var string
     *
     * @ORM\Column(name="tramiteaeu", type="string", length=255, nullable=true)
     */
    private $tramiteaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="tramiteaes", type="string", length=255, nullable=true)
     */
    private $tramiteaes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set tramiteaeu
     *
     * @param string $tramiteaeu
     * @return Tramitea
     */
    public function setTramiteaeu($tramiteaeu)
    {
        $this->tramiteaeu = $tramiteaeu;

        return $this;
    }

    /**
     * Get tramiteaeu
     *
     * @return string 
     */
    public function getTramiteaeu()
    {
        return $this->tramiteaeu;
    }

    /**
     * Set tramiteaes
     *
     * @param string $tramiteaes
     * @return Tramitea
     */
    public function setTramiteaes($tramiteaes)
    {
        $this->tramiteaes = $tramiteaes;

        return $this;
    }

    /**
     * Get tramiteaes
     *
     * @return string 
     */
    public function getTramiteaes()
    {
        return $this->tramiteaes;
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
     * @return Tramitea
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
