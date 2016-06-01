<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaTramitea
 *
 * @ORM\Table(name="fitxa_tramitea", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="tramitea_id_idx", columns={"tramitea_id"})})
 * @ORM\Entity
 */
class FitxaTramitea
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ordena", type="bigint", nullable=true)
     */
    private $ordena;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Tramitea
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Tramitea")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tramitea_id", referencedColumnName="id")
     * })
     */
    private $tramitea;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Fitxa
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Fitxa",inversedBy="tramiteak")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fitxa_id", referencedColumnName="id")
     * })
     */
    private $fitxa;


    public function __toString()
    {
        return $this->getTramitea();
    }


    /**
     * Set ordena
     *
     * @param integer $ordena
     * @return FitxaTramitea
     */
    public function setOrdena($ordena)
    {
        $this->ordena = $ordena;

        return $this;
    }

    /**
     * Get ordena
     *
     * @return integer 
     */
    public function getOrdena()
    {
        return $this->ordena;
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
     * Set tramitea
     *
     * @param \Zerbikat\BackendBundle\Entity\Tramitea $tramitea
     * @return FitxaTramitea
     */
    public function setTramitea(\Zerbikat\BackendBundle\Entity\Tramitea $tramitea = null)
    {
        $this->tramitea = $tramitea;

        return $this;
    }

    /**
     * Get tramitea
     *
     * @return \Zerbikat\BackendBundle\Entity\Tramitea 
     */
    public function getTramitea()
    {
        return $this->tramitea;
    }

    /**
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     * @return FitxaTramitea
     */
    public function setFitxa(\Zerbikat\BackendBundle\Entity\Fitxa $fitxa = null)
    {
        $this->fitxa = $fitxa;

        return $this;
    }

    /**
     * Get fitxa
     *
     * @return \Zerbikat\BackendBundle\Entity\Fitxa 
     */
    public function getFitxa()
    {
        return $this->fitxa;
    }
}
