<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaAzpiatala
 *
 * @ORM\Table(name="fitxa_azpiatala", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="azpiatala_id_idx", columns={"azpiatala_id"})})
 * @ORM\Entity
 */
class FitxaAzpiatala
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
     * @var \Zerbikat\BackendBundle\Entity\Fitxa
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Fitxa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fitxa_id", referencedColumnName="id")
     * })
     */
    private $fitxa;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Azpiatala
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Azpiatala")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="azpiatala_id", referencedColumnName="id")
     * })
     */
    private $azpiatala;



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
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     * @return FitxaAzpiatala
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

    /**
     * Set azpiatala
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpiatala $azpiatala
     * @return FitxaAzpiatala
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
}
