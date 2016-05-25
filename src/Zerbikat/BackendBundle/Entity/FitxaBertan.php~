<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaBertan
 *
 * @ORM\Table(name="fitxa_bertan", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="bertan_id_idx", columns={"bertan_id"})})
 * @ORM\Entity
 */
class FitxaBertan
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
     * @var \Zerbikat\BackendBundle\Entity\Bertan
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Bertan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bertan_id", referencedColumnName="id")
     * })
     */
    private $bertan;



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
     * @return FitxaBertan
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
     * Set bertan
     *
     * @param \Zerbikat\BackendBundle\Entity\Bertan $bertan
     * @return FitxaBertan
     */
    public function setBertan(\Zerbikat\BackendBundle\Entity\Bertan $bertan = null)
    {
        $this->bertan = $bertan;

        return $this;
    }

    /**
     * Get bertan
     *
     * @return \Zerbikat\BackendBundle\Entity\Bertan 
     */
    public function getBertan()
    {
        return $this->bertan;
    }
}
