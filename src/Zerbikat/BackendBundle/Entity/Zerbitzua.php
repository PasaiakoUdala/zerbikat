<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zerbitzua
 *
 * @ORM\Table(name="zerbitzua")
 * @ORM\Entity
 */
class Zerbitzua
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
     * @ORM\Column(name="kodea", type="string", length=10, nullable=false)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="zerbitzuaeu", type="string", length=255, nullable=true)
     */
    private $zerbitzuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="zerbitzuaes", type="string", length=255, nullable=true)
     */
    private $zerbitzuaes;


    /**
     *      ERLAZIOAK
     */

    /**
     * @ORM\ManyToOne(targetEntity="Espedientekudeaketa")
     * @ORM\JoinColumn(name="espedientekudeaketa_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $espedientekudeaketa;


    /**
     *          TOSTRING
     */
    public function __toString()
    {
        return $this->getKodea()."-".$this->getZerbitzuaeu();
    }

    /**
     *          FUNTZIOAK
     */

    /**
     * Set kodea
     *
     * @param string $kodea
     * @return Zerbitzua
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
     * Set zerbitzuaeu
     *
     * @param string $zerbitzuaeu
     * @return Zerbitzua
     */
    public function setZerbitzuaeu($zerbitzuaeu)
    {
        $this->zerbitzuaeu = $zerbitzuaeu;

        return $this;
    }

    /**
     * Get zerbitzuaeu
     *
     * @return string 
     */
    public function getZerbitzuaeu()
    {
        return $this->zerbitzuaeu;
    }

    /**
     * Set zerbitzuaes
     *
     * @param string $zerbitzuaes
     * @return Zerbitzua
     */
    public function setZerbitzuaes($zerbitzuaes)
    {
        $this->zerbitzuaes = $zerbitzuaes;

        return $this;
    }

    /**
     * Get zerbitzuaes
     *
     * @return string 
     */
    public function getZerbitzuaes()
    {
        return $this->zerbitzuaes;
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
     * @return Zerbitzua
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
     * Set espedientekudeaketa
     *
     * @param \Zerbikat\BackendBundle\Entity\Espedientekudeaketa $espedientekudeaketa
     *
     * @return Zerbitzua
     */
    public function setEspedientekudeaketa(\Zerbikat\BackendBundle\Entity\Espedientekudeaketa $espedientekudeaketa = null)
    {
        $this->espedientekudeaketa = $espedientekudeaketa;

        return $this;
    }

    /**
     * Get espedientekudeaketa
     *
     * @return \Zerbikat\BackendBundle\Entity\Espedientekudeaketa
     */
    public function getEspedientekudeaketa()
    {
        return $this->espedientekudeaketa;
    }
}
