<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Arrunta
 *
 * @ORM\Table(name="arrunta")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Arrunta
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
     * @var integer
     *
     * @ORM\Column(name="origenid", type="bigint", nullable=true)
     */
    private $origenid;

    /**
     * @var string
     *
     * @ORM\Column(name="epeaeu", type="string", length=255, nullable=true)
     */
    private $epeaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="epeaes", type="string", length=255, nullable=true)
     */
    private $epeaes;


    /**
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;


    /**
     *          FUNTZIOAK
     */
    public function __toString()
    {
        return (string) $this->getEpeaeu();
    }


    /**
     * Set epeaeu
     *
     * @param string $epeaeu
     * @return Arrunta
     */
    public function setEpeaeu($epeaeu)
    {
        $this->epeaeu = $epeaeu;

        return $this;
    }

    /**
     * Get epeaeu
     *
     * @return string 
     */
    public function getEpeaeu()
    {
        return $this->epeaeu;
    }

    /**
     * Set epeaes
     *
     * @param string $epeaes
     * @return Arrunta
     */
    public function setEpeaes($epeaes)
    {
        $this->epeaes = $epeaes;

        return $this;
    }

    /**
     * Get epeaes
     *
     * @return string 
     */
    public function getEpeaes()
    {
        return $this->epeaes;
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
     * @return Arrunta
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

    /**
     * Set origenid
     *
     * @param integer $origenid
     *
     * @return Arrunta
     */
    public function setOrigenid($origenid)
    {
        $this->origenid = $origenid;

        return $this;
    }

    /**
     * Get origenid
     *
     * @return integer
     */
    public function getOrigenid()
    {
        return $this->origenid;
    }
}
