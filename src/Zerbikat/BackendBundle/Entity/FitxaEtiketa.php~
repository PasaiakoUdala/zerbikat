<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaEtiketa
 *
 * @ORM\Table(name="fitxa_etiketa", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="etiketa_id_idx", columns={"etiketa_id"})})
 * @ORM\Entity
 */
class FitxaEtiketa
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
     * @var \Zerbikat\BackendBundle\Entity\Etiketa
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Etiketa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etiketa_id", referencedColumnName="id")
     * })
     */
    private $etiketa;



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
     * @return FitxaEtiketa
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
     * Set etiketa
     *
     * @param \Zerbikat\BackendBundle\Entity\Etiketa $etiketa
     * @return FitxaEtiketa
     */
    public function setEtiketa(\Zerbikat\BackendBundle\Entity\Etiketa $etiketa = null)
    {
        $this->etiketa = $etiketa;

        return $this;
    }

    /**
     * Get etiketa
     *
     * @return \Zerbikat\BackendBundle\Entity\Etiketa 
     */
    public function getEtiketa()
    {
        return $this->etiketa;
    }
}
