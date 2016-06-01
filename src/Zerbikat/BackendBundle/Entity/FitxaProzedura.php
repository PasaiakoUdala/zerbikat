<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FitxaProzedura
 *
 * @ORM\Table(name="fitxa_prozedura", indexes={@ORM\Index(name="fitxa_id_idx", columns={"fitxa_id"}), @ORM\Index(name="prozedura_id_idx", columns={"prozedura_id"})})
 * @ORM\Entity
 */
class FitxaProzedura
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
     * @ORM\ManyToOne(targetEntity="Prozedura", inversedBy="fitxak")
     * @ORM\JoinColumn(name="prozedura_id", referencedColumnName="id")
     * */
    protected $prozedura;

    /**
     * @ORM\ManyToOne(targetEntity="Fitxa", inversedBy="prozedurak")
     * @ORM\JoinColumn(name="fitxa_id", referencedColumnName="id")
     * */
    protected $fitxa;

    public function __toString()
    {
        return $this->getTramitea();
    }


    /**
     * Set ordena
     *
     * @param integer $ordena
     *
     * @return FitxaProzedura
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
     * Set prozedura
     *
     * @param \Zerbikat\BackendBundle\Entity\Prozedura $prozedura
     *
     * @return FitxaProzedura
     */
    public function setProzedura(\Zerbikat\BackendBundle\Entity\Prozedura $prozedura = null)
    {
        $this->prozedura = $prozedura;

        return $this;
    }

    /**
     * Get prozedura
     *
     * @return \Zerbikat\BackendBundle\Entity\Prozedura
     */
    public function getProzedura()
    {
        return $this->prozedura;
    }

    /**
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     *
     * @return FitxaProzedura
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
