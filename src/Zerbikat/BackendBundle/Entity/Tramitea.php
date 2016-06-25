<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Tramitea
 *
 * @ORM\Table(name="tramitea")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Tramitea
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
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala", cascade={"remove"})
     *
     */
    private $udala;
    

    public function __toString()
    {
        return $this->getTramiteaeu();
    }
    


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
