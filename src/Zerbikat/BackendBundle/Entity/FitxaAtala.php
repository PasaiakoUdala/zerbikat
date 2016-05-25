<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaAtala
 *
 * @ORM\Table(name="fitxa_atala", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="atala_id_idx", columns={"atala_id"})})
 * @ORM\Entity
 */
class FitxaAtala
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
     * @var \Zerbikat\BackendBundle\Entity\Atala
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Atala")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="atala_id", referencedColumnName="id")
     * })
     */
    private $atala;



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
     * @return FitxaAtala
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
     * Set atala
     *
     * @param \Zerbikat\BackendBundle\Entity\Atala $atala
     * @return FitxaAtala
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
}
