<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Dokumentumota
 *
 * @ORM\Table(name="dokumentumota")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Dokumentumota
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
     * @var string
     *
     * @ORM\Column(name="kodea", type="string", length=255, nullable=true)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="motaeu", type="string", length=255, nullable=true)
     */
    private $motaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="motaes", type="string", length=255, nullable=true)
     */
    private $motaes;

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
     *      FUNTZIOAK
     * 
     * 
     */


    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getMotaeu();
    }


    /**
     * Set kodea
     *
     * @param string $kodea
     * @return Dokumentumota
     */
    public function setKodea($kodea)
    {
        $this->kodea = $kodea;

        return $this;
    }

    /**
     * Get kodea
     *
     * @return string 
     */
    public function getKodea()
    {
        return $this->kodea;
    }

    /**
     * Set motaeu
     *
     * @param string $motaeu
     * @return Dokumentumota
     */
    public function setMotaeu($motaeu)
    {
        $this->motaeu = $motaeu;

        return $this;
    }

    /**
     * Get motaeu
     *
     * @return string 
     */
    public function getMotaeu()
    {
        return $this->motaeu;
    }

    /**
     * Set motaes
     *
     * @param string $motaes
     * @return Dokumentumota
     */
    public function setMotaes($motaes)
    {
        $this->motaes = $motaes;

        return $this;
    }

    /**
     * Get motaes
     *
     * @return string 
     */
    public function getMotaes()
    {
        return $this->motaes;
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
     * @return Dokumentumota
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
}
