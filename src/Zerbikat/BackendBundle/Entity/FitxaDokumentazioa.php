<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaDokumentazioa
 *
 * @ORM\Table(name="fitxa_dokumentazioa", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="dokumentazioa_id_idx", columns={"dokumentazioa_id"})})
 * @ORM\Entity
 */
class FitxaDokumentazioa
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
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Fitxa",inversedBy="dokumentazioak")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fitxa_id", referencedColumnName="id")
     * })
     */
    private $fitxa;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Dokumentazioa
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Dokumentazioa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dokumentazioa_id", referencedColumnName="id")
     * })
     */
    private $dokumentazioa;


    public function __toString()
    {
        return $this->dokumentazioa->getKodea()."-".$this->dokumentazioa->getDeskribapenaeu();
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
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     * @return FitxaDokumentazioa
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
     * Set dokumentazioa
     *
     * @param \Zerbikat\BackendBundle\Entity\Dokumentazioa $dokumentazioa
     * @return FitxaDokumentazioa
     */
    public function setDokumentazioa(\Zerbikat\BackendBundle\Entity\Dokumentazioa $dokumentazioa = null)
    {
        $this->dokumentazioa = $dokumentazioa;

        return $this;
    }

    /**
     * Get dokumentazioa
     *
     * @return \Zerbikat\BackendBundle\Entity\Dokumentazioa 
     */
    public function getDokumentazioa()
    {
        return $this->dokumentazioa;
    }
}
