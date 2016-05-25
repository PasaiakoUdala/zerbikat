<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaKontzeptua
 *
 * @ORM\Table(name="fitxa_kontzeptua", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="kontzeptua_id_idx", columns={"kontzeptua_id"})})
 * @ORM\Entity
 */
class FitxaKontzeptua
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
     * @var \Zerbikat\BackendBundle\Entity\Kontzeptua
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Kontzeptua")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kontzeptua_id", referencedColumnName="id")
     * })
     */
    private $kontzeptua;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set kontzeptua
     *
     * @param \Zerbikat\BackendBundle\Entity\Kontzeptua $kontzeptua
     * @return FitxaKontzeptua
     */
    public function setKontzeptua(\Zerbikat\BackendBundle\Entity\Kontzeptua $kontzeptua = null)
    {
        $this->kontzeptua = $kontzeptua;

        return $this;
    }

    /**
     * Get kontzeptua
     *
     * @return \Zerbikat\BackendBundle\Entity\Kontzeptua 
     */
    public function getKontzeptua()
    {
        return $this->kontzeptua;
    }

    /**
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     * @return FitxaKontzeptua
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
