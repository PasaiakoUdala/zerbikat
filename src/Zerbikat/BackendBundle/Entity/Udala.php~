<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Udala
 *
 * @ORM\Table(name="udala")
 * @ORM\Entity
 */
class Udala
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="izenaeu", type="string", length=255)
     */
    private $izenaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="izenaes", type="string", length=255)
     */
    private $izenaes;

    /**
     * @var string
     *
     * @ORM\Column(name="kodea", type="string", length=255)
     */
    private $kodea;

    /**
     * @var string
     *
     * @ORM\Column(name="logoa", type="string", length=255)
     */
    private $logoa;

    

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
     * Set izenaeu
     *
     * @param string $izenaeu
     * @return Udala
     */
    public function setIzenaeu($izenaeu)
    {
        $this->izenaeu = $izenaeu;

        return $this;
    }

    /**
     * Get izenaeu
     *
     * @return string 
     */
    public function getIzenaeu()
    {
        return $this->izenaeu;
    }

    /**
     * Set izenaes
     *
     * @param string $izenaes
     * @return Udala
     */
    public function setIzenaes($izenaes)
    {
        $this->izenaes = $izenaes;

        return $this;
    }

    /**
     * Get izenaes
     *
     * @return string 
     */
    public function getIzenaes()
    {
        return $this->izenaes;
    }

    /**
     * Set kodea
     *
     * @param string $kodea
     * @return Udala
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
    
    public function __toString()
    {
        return $this->getKodea();
    }
    
    

    /**
     * Set logoa
     *
     * @param string $logoa
     *
     * @return Udala
     */
    public function setLogoa($logoa)
    {
        $this->logoa = $logoa;

        return $this;
    }

    /**
     * Get logoa
     *
     * @return string
     */
    public function getLogoa()
    {
        return $this->logoa;
    }
}
