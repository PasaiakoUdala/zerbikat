<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaFamilia
 *
 * @ORM\Table(name="fitxa_familia", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="familia_id_idx", columns={"familia_id"})})
 * @ORM\Entity
 */
class FitxaFamilia
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
     * @var \Zerbikat\BackendBundle\Entity\Familia
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Familia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="familia_id", referencedColumnName="id")
     * })
     */
    private $familia;



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
     * @return FitxaFamilia
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
     * Set familia
     *
     * @param \Zerbikat\BackendBundle\Entity\Familia $familia
     * @return FitxaFamilia
     */
    public function setFamilia(\Zerbikat\BackendBundle\Entity\Familia $familia = null)
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * Get familia
     *
     * @return \Zerbikat\BackendBundle\Entity\Familia 
     */
    public function getFamilia()
    {
        return $this->familia;
    }
}
